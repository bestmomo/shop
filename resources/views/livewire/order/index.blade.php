<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\{ Country, Range, Product, Page, State, Shop, User };
use Darryldecode\Cart\CartCollection;
use Illuminate\Support\Facades\Mail;
use App\Mail\{ NewOrder, ProductAlert, Ordered };
use Stripe\Stripe;
use Stripe\TaxRate;
use Stripe\Checkout\Session as CheckoutSession;

new #[Title('Order')]
class extends Component {

    public Collection $addresses;
    public bool $hasMultipleAddresses = false;
    public $selectedBillingAddress;
    public $selectedDeliveryAddress;
    public bool $sameAddress = true;
    public int $selectedDeliveryOption = 1;
    public string $selectedPaymentOption = 'carte';
    public CartCollection $content;
    public float $total;
    public float $tax;
    public bool $pick = false;
    public float $shipping;
    public float $tvaBase;
    public Shop $shop;

    public function mount()
    {
        if(Cart::isEmpty()) abort(404);

        session()->forget('checkout_session_id');

        $this->shop = Shop::firstOrFail();

        $this->addresses = Auth::user()->addresses()->get();

        if($this->addresses->isEmpty()) {
            return redirect()->route('addresses.create');
        }

        $this->hasMultipleAddresses = $this->addresses->count() > 1;

        $this->selectedBillingAddress = $this->addresses->first()->id;
        $this->selectedDeliveryAddress = $this->addresses->first()->id;

        $this->shipping = $this->calculateShipping();

        if (!$this->shipping) {
            return redirect()->route('cart')->with('message', trans('The weight of your order exceeds the processing capacity of our store. Please contact us or reduce the quantity.'));
        }

        $this->calculateDetail();
    }

    public function toggleSameAddress(): void
    {
        $this->sameAddress = !$this->sameAddress;
        $this->updateDeliveryAddress();
    }

    public function updatedselectedBillingAddress($value): void
    {
        $this->updateDeliveryAddress();
    }

    private function updateDeliveryAddress(): void
    {
        $this->selectedDeliveryAddress = $this->sameAddress
            ? $this->selectedBillingAddress
            : $this->addresses->where('id', '!=', $this->selectedBillingAddress)->first()->id ?? $this->selectedBillingAddress;

        $this->shipping = $this->calculateShipping();
        $this->calculateDetail();
    }

    public function updatedselectedDeliveryOption($value): void
    {
        $this->pick = $value == '2';
        if ($this->pick) {
            $this->sameAddress = true;
            $this->selectedDeliveryAddress = $this->selectedBillingAddress;
            $this->shipping = 0;
        }
        $this->shipping = $this->calculateShipping();
        $this->calculateDetail();
    }

    public function updatedselectedDeliveryAddress(): void
    {
        $this->shipping = $this->calculateShipping();
        $this->calculateDetail();
    }

    private function calculateShipping(): float|false
    {
        if ($this->pick) {
            return 0;
        }
        $address = $this->addresses->firstWhere('id', $this->selectedDeliveryAddress);
        $items = Cart::getContent();
        $weight = $items->sum(function ($item) {
            return $item->quantity * $item->model->weight;
        });
        $range = Range::orderBy('max')->where('max', '>=', $weight)->first(); 
        return $range ? $range->countries()->where('countries.id', $address->country_id)->first()->pivot->price : false;
    }

    private function calculateDetail(): void
    {
        $country_delivery = $this->addresses->firstWhere('id', $this->selectedDeliveryAddress)->country;
        $this->tvaBase = Country::where('tax', '>', 0)->first()->tax;
        $this->tax = $this->pick ? $this->tvaBase : $country_delivery->tax; 
        $this->content = Cart::getContent();
        $this->total = $this->tax > 0 ? Cart::getTotal() : Cart::getTotal() / (1 + $this->tvaBase);
    }

    public function saveOrder()
    {
        $items = Cart::getContent();

        // Vérification du stock
        foreach($items as $row) {
            $product = Product::findOrFail($row->id);
            if($product->quantity < $row->quantity) {
                return redirect()->route('cart')->with('message', trans("We're sorry, but the product :name does not have enough stock to satisfy your request. We only have :quantity available.", ['name' => $product->name, 'quantity' => $product->quantity]));
            }
        }

        // Adresses
        $address_facturation = $this->addresses->firstWhere('id', $this->selectedBillingAddress);
        $address_livraison = $this->addresses->firstWhere('id', $this->selectedDeliveryAddress);

        // Enregistrement commande
        $order = Auth::user()->orders()->create([
            'reference' => strtoupper(Str::random(8)),
            'shipping' => $this->shipping,
            'tax' => $this->tax,
            'total' => $this->tax > 0 ? Cart::getTotal() : Cart::getTotal() / (1 + $this->tvaBase),
            'payment' => $this->selectedPaymentOption,
            'pick' => $this->pick,
            'state_id' => State::whereSlug($this->selectedPaymentOption)->first()->id,
        ]);

        // Enregistrement adresse de facturation
        $order->addresses()->create($address_facturation->toArray());
        
        // Enregistrement éventuel adresse de livraison si différente
        if(!$this->sameAddress) {
            $address_livraison->facturation = false;
            $order->addresses()->create($address_livraison->toArray());
        }

        // Enregistrement des produits
        foreach($items as $row) {
            $order->products()->create(
                [
                    'name' => $row->name,
                    'total_price_gross' => ($this->tax > 0 ? $row->price : $row->price / (1 + $this->tvaBase)) * $row->quantity,
                    'quantity' => $row->quantity,
                ]
            );
            $product = Product::findOrFail($row->id);         
            $product->quantity -= $row->quantity;
            $product->save();
            if($product->quantity + $row->quantity > $product->quantity_alert && $product->quantity <= $product->quantity_alert) {
                $admins = User::whereAdmin(true)->get();
                foreach($admins as $admin) {
                    Mail::to($admin)->send(new ProductAlert($this->shop, $product));
                }  
            }               
        }

        // On vide le panier et la session
        Cart::clear();
        Cart::session(Auth::user())->clear(); 

        // Notification à l'administrateur
        $admins = User::whereAdmin(true)->get();
        foreach($admins as $admin) {
            Mail::to($admin)->send(new NewOrder($this->shop, $order));
        }

        // Si par carte on crée le checkout
        if($this->selectedPaymentOption === 'carte') {
            Stripe::setApiKey(config('stripe.secret_key'));

            // Crée un objet de taxe si le taux est supérieur à zéro
            $tax_rate = null;
            if ($this->tax > 0) {
                $tax_rate = TaxRate::create([
                    'display_name' => 'TVA',
                    'percentage' => $this->tax * 100,
                    'inclusive' => true,
                ]);
            }

            // Produits
            $products = [];

            foreach($items as $row) {
                $products[] = [
                    'name' => $row->name,
                    'price' => (int)(($this->tax > 0 ? $row->price : price_without_vat($row->price)) * 100),
                    'quantity' => $row->quantity,
                ];
            }

            $line_items = [];
            foreach ($products as $product) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product['name'],
                        ],
                        'unit_amount' => $product['price'],
                        'tax_behavior' => 'inclusive',
                    ],
                    'quantity' => $product['quantity'],
                    'tax_rates' => $tax_rate ? [$tax_rate->id] : [],
                ];
            }

            // Ajoute les frais de port éventuels
            if ($this->shipping > 0) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Frais de port',
                        ],
                        'unit_amount' => (int)($this->shipping * 100),
                    ],
                    'quantity' => 1,
                    'tax_rates' => [],
                ];
            }            

            // Crée la session
            $checkout_session = CheckoutSession::create([
                'success_url' => route('order.card', $order->id),
                'line_items' => $line_items,
                'mode' => 'payment',
                'customer_email' => Auth::user()->email,
            ]);

            session(['checkout_session_id' => $checkout_session->id,]);

            return redirect()->away($checkout_session->url);
        } else {
            // Notification au client
            Mail::to(Auth::user())->send(new Ordered($this->shop, $order));
        }

        return redirect()->route('order.confirmation', $order->id);
    }

    public function with(): array
    {
        $paymentOptions = [];

        if ($this->shop->card) {
            $paymentOptions[] = [
                'id' => 'carte',
                'name' => trans('Credit card'),
                'text' => trans('You will be directed to the Stripe payment page after your order has been validated.')
            ];
        }

        if ($this->shop->mandat) {
            $paymentOptions[] = [
                'id' => 'mandat',
                'name' => trans('Administrative mandate'),
                'text' => trans('Send us a purchase order. Your order will be shipped upon receipt of this order. Do not forget to specify in your order the reference which will be specified when validating your order.')
            ];
        }

        if ($this->shop->transfer) {
            $paymentOptions[] = [
                'id' => 'virement',
                'name' => trans('Bank transfer'),
                'text' => trans('You will need to transfer the order amount to our bank account. You will receive your order confirmation including our bank details and order number. The goods will be held for 30 days for you and we will process your order as soon as payment is received.')
            ];
        }

        if ($this->shop->check) {
            $paymentOptions[] = [
                'id' => 'cheque',
                'name' => trans('Check'),
                'text' => trans('You will need to send us a check for the amount of the order. You will receive your order confirmation including our bank details and the order number. The goods will be held for 30 days for you and we will process your order as soon as payment is received.')
            ];
        }

        return [
            'deliveryOptions' => [
                ['id' => '1', 'name' => trans('Colissimo')],
                ['id' => '2', 'name' => trans('Pick-up on site')],
            ],
            'paymentOptions' => $paymentOptions
        ];
    }

}; ?>

<div>
    <x-card class="flex items-center justify-center mt-6 bg-gray-100 w-full lg:max-w-[80%] lg:mx-auto" title="{{ __('My order') }}" shadow separator>
        @if (!$hasMultipleAddresses)
            <x-card class="w-full sm:min-w-[50vw]" title="{!! $pick || !$sameAddress ? trans('Billing') : trans('Billing & Delivery') !!}" shadow separator >
                <div class="grid grid-cols-2 gap-6">
                    <x-card class="w-full bg-green-100 shadow-md shadow-gray-500" title=" ">
                        <x-address :address="$addresses->first()" />
                    </x-card>
                </div>
                <x-slot:actions>
                    <x-button label="{{ trans('Manage my addresses') }}" class="btn-primary" link="{{ route('addresses') }}" /> 
                </x-slot:actions>
            </x-card>
        @else
            <x-card class="w-full sm:min-w-[50vw]" title="{{ trans('Addresses') }}" shadow separator >
                <div class="grid grid-cols-1 gap-6 items-start md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($addresses as $address)
                        <label class="inline-flex items-start">
                            <x-card class="w-full ml-2 shadow-md shadow-gray-500 transition duration-300 {{ $selectedBillingAddress == $address->id ? 'bg-blue-100' : '' }}" title=" ">                         
                                <input type="radio" class="form-radio" name="billingAddress" wire:model="selectedBillingAddress" value="{{ $address->id }}"  wire:change="$refresh">
                                <span class="ml-2 font-bold">{{ ($pick || !$sameAddress) ? __('Billing') : __('Billing & Delivery') }}</span>
                                <x-address :address="$address" />
                            </x-card>
                        </label>
                    @endforeach
                </div>
                @if (!$pick && !$sameAddress)
                    <br><hr>
                    <div class="grid gap-6 items-start mt-4 md:grid-cols-2 lg:grid-cols-4">
                        @foreach ($addresses as $address)
                            @if($address->id != $selectedBillingAddress)
                                <label class="inline-flex items-start">
                                    <x-card class="w-full ml-2 shadow-md shadow-gray-500 transition duration-300 {{ $selectedDeliveryAddress == $address->id ? 'bg-blue-100' : '' }}" title=" ">
                                        <input type="radio" class="form-radio" name="deliveryAddress" wire:model="selectedDeliveryAddress" value="{{ $address->id }}" wire:change="$refresh">
                                        <span class="ml-2 font-bold">{{ trans('Delivery') }}</span>
                                        <x-address :address="$address" />
                                    </x-card>
                                </label>
                            @endif
                        @endforeach
                    </div>
                @endif
                <x-slot:actions>
                    <div class="flex flex-col justify-start items-start space-y-2 w-full sm:flex-row sm:space-y-0 sm:space-x-2">
                        @if (!$pick)
                            <x-button wire:click="toggleSameAddress" label="{{ $sameAddress ? trans('Use different delivery address') : trans('Use same address for billing and delivery') }}" class="btn-primary" />
                        @endif
                        <x-button label="{{ trans('Manage my addresses') }}" class="btn-primary" link="{{ route('addresses') }}" />
                    </div>                                                   
                </x-slot:actions>
            </x-card>
        @endif
    
        <br>  
        <x-card class="w-full sm:min-w-[50vw]" title="{{ trans('Delivery mode') }}" shadow separator >
            <x-radio :options="$deliveryOptions" wire:model="selectedDeliveryOption" wire:change="$refresh" />
        </x-card>
        <br>  
        <x-card class="w-full sm:min-w-[50vw]" title="{{ trans('Mode of payment') }}" shadow separator >
            <x-radio :options="$paymentOptions" wire:model="selectedPaymentOption" wire:change="$refresh" />
            <br>
            <p>{{ collect($paymentOptions)->firstWhere('id', $selectedPaymentOption)['text'] }}</p>
        </x-card>
        <br>
        <x-card x-data="{ isChecked: false }" class="w-full sm:min-w-[50vw]" title="{{ __('My order details') }}" shadow separator >
            <x-details 
                :content="$content" 
                :shipping="$shipping" 
                :tax="$tax" 
                :total="$total"
                :pick="$pick"
            />
            <hr><br>
            <p class="mb-2 text-xl">{{ trans('Please check your order before validation!') }}</p>
            <input id="ok" name="ok" type="checkbox" x-model="isChecked" />
            <span>{{ trans('I have read the general terms and conditions of sale and the cancellation policy and accept them unreservedly.') }}</span>
            <x-slot:actions>
                <x-button label="{{ trans('Order with payment obligation') }}" wire:click="saveOrder" class="mt-2 w-full btn-primary" x-bind:disabled="!isChecked" spinner />
            </x-slot:actions>
        </x-card>
    </x-card>
</div>

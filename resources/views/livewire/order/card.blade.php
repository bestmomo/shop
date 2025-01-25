<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use App\Models\{ Order, Shop, State, Payment };
use Illuminate\Support\Facades\Auth;
use App\Services\Invoice;
use Illuminate\Support\Facades\Mail;
use App\Mail\Ordered;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

new #[Title('Card')]
class extends Component {

    public Order $order;
    public Shop $shop;
    public bool $paid = false;

    public function mount($id, Invoice $invoice): void
    {
        $this->order = Order::findOrFail($id);
        $this->shop = Shop::firstOrFail();

        if (Auth::user()->id != $this->order->user_id) {
            abort(403);
        }

        if (session()->has('checkout_session_id')) {
            Stripe::setApiKey(config('stripe.secret_key'));
            try {
                $session = CheckoutSession::retrieve(session('checkout_session_id'));
            } catch (ApiErrorException $e) {
                Log::error('Stripe API Error: ' . $e->getMessage());
                abort(500, trans('An error occurred while processing your payment.'));
            }
            
            if($session->payment_status === 'paid') {
                $this->paid = true;
                $this->order->state_id = State::whereSlug('paiement_ok')->first()->id;  
                $this->order->save();       
                $payment = new Payment(['payment_id' => $session->payment_intent,]);
                $this->order->payment_infos()->save($payment);            
                // Création de la facture
                $response = $invoice->create($this->order, true);  
                if($response->successful()) {
                    $data = json_decode($response->body());
                    $this->order->invoice_id = $data->id;
                    $this->order->invoice_number = $data->number;
                    $this->order->save();
                }                 
            } else {
                $this->order->state_id = State::whereSlug('erreur')->first()->id;
                $this->order->save();
            }

            session()->forget('checkout_session_id');
            Mail::to(Auth::user())->send(new Ordered($this->shop, $this->order));

        } else {
            abort(404);
        }
    } 

}; ?>

<div>
    <x-card 
        class="flex items-center justify-center mt-6 bg-gray-100 w-full lg:max-w-[80%] lg:mx-auto" 
        title="" 
        shadow 
        separator>
            @if($paid)
                <x-badge value="{!! trans('Your payment has been validated') !!}" class="p-3 badge-success" /><br><br>
                <p>{{ $order->pick ? trans('You can come and pick up your order') : trans('Your order will be shipped to you') }}</p>
                <p>{{ trans('You can retrieve your invoice from your account') }}</p>
            @else
                <x-badge value="{!! trans('Your payment has not been validated') !!}" class="p-3 badge-error" /><br><br>
                <p>{{ trans('Please contact us') }}</p>
            @endif
    </x-card>
</div>

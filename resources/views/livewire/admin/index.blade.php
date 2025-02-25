<?php

use App\Traits\ManageOrders;
use Livewire\Volt\Component;
use App\Services\Marketing;
use App\Services\OrderService;
use App\Models\{Order, Product, User, Setting};
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\{Layout, Title};

new #[Layout('components.layouts.admin')] class extends Component {
    use ManageOrders;

    public bool $openGlance = true;
    public bool $openOrders = true;
    public bool $paginationOrders = false;

    public function headersProducts(): array
    {
        return [['key' => 'image', 'label' => ''], ['key' => 'name', 'label' => __('Name')], ['key' => 'quantity_alert', 'label' => __('Quantity alert'), 'class' => 'text-right'], ['key' => 'quantity', 'label' => __('Quantity'), 'class' => 'text-right']];
    }
    public function mount()
    {
        $this->global_promotion = (new Marketing())->globalPromotion();
    }
    public function with(): array
    {
        $orders = (new OrderService($this))->req()->take(6)->get();
        $orders = $this->setPrettyOrdersIndexes($orders);

        $promotion = Setting::where('key', 'promotion')->firstOrCreate(['key' => 'promotion']);
        $textPromotion = '';

        if ($promotion->value) {
            $now = now();
            if ($now->isBefore($promotion->date1)) {
                $textPromotion = transL('Coming soon');
            } elseif ($now->between($promotion->date1, $promotion->date2)) {
                $textPromotion = trans('in progress');
            } else {
                $textPromotion = transL('Expired_feminine');
            }
        }

        return [
            'productsCount' => Product::where('active', true)->count(),
            'ordersCount' => Order::whereRelation('state', 'indice', '>', 3)->whereRelation('state', 'indice', '<', 6)->count(),
            'usersCount' => User::count(),
            'orders' => $orders->collect(),
            'global_promotion' => $this->global_promotion,
            'promotion' => $promotion,
            'textPromotion' => $textPromotion,
            'headersOrders' => $this->headersOrders(),
            'productsDown' => Product::whereColumn('quantity', '<=', 'quantity_alert')->orderBy('quantity', 'asc')->get(),
            'headersProducts' => $this->headersProducts(),
            'row_decoration' => [
                'bg-red-400' => fn(Product $product) => $product->quantity == 0,
            ],
        ];
    }
}; ?>

<div>
    <x-collapse wire:model="openGlance" class="shadow-md">
        <x-slot:heading>
            @lang('In a glance')
        </x-slot:heading>
        <x-slot:content class="flex flex-wrap gap-4">
            <a href="{{ route('admin.products.index') }}" class="flex-grow">
                <x-stat title="{{ __('Active products') }}" description="" value="{{ $productsCount }}"
                    icon="s-shopping-bag" class="shadow-hover" />
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex-grow">
                <x-stat title="{{ __('Successful orders') }}" description="" value="{{ $ordersCount }}"
                    icon="s-shopping-cart" class="shadow-hover" />
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex-grow">
                <x-stat title="{{ __('Customers') }}" description="" value="{{ $usersCount }}" icon="s-user"
                    class="shadow-hover" />
            </a>
        </x-slot:content>
    </x-collapse>

    @livewire('mktg.shop.global-promotion', ['promotion' => $global_promotion, 'target' => 'back'])

    <x-header separator progress-indicator />

    @if ($productsDown->isNotEmpty())
        <x-collapse class="shadow-md bg-red-500">
            <x-slot:heading>
                @lang('Stock alert')
            </x-slot:heading>
            <x-slot:content>
                <x-card class="mt-6" title="" shadow separator>
                    <x-table striped :rows="$productsDown" :headers="$headersProducts" link="/admin/products/{id}/edit"
                        :row-decoration="$row_decoration">
                        @scope('cell_image', $product)
                            <img src="{{ asset('storage/photos/' . $product->image) }}" width="60" alt="">
                        @endscope
                    </x-table>
                    <x-slot:actions>
                        <x-button label="{{ __('See all products') }}" class="btn-primary" icon="s-list-bullet"
                            link="{{ route('admin.products.index') }}" />
                    </x-slot:actions>
                </x-card>
            </x-slot:content>
        </x-collapse>
        <br>
    @endif

    <x-collapse wire:model="openOrders" class="shadow-md">
        <x-slot:heading>
            @lang('Latest orders')
        </x-slot:heading>

        <x-slot:content>
            <x-card class="mt-6" shadow separator>
                @include('livewire.admin.orders.table')
                <x-slot:actions>
                    <x-button label="{{ __('See all orders') }}" class="btn-primary" icon="s-list-bullet"
                        link="{{ route('admin.orders.index') }}" />
                </x-slot:actions>
            </x-card>
        </x-slot:content>
    </x-collapse>

</div>

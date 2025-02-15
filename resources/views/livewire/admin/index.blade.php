<?php

use App\Traits\ManageOrders;
use Livewire\Volt\Component;
use App\Services\OrderService;
use App\Models\{Order, Product, User, Setting};
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\{Layout, Title};

new #[Layout('components.layouts.admin')]
class extends Component {
    use ManageOrders;

    public bool $openGlance = true;
    public bool $openOrders = true;
    public bool $paginationOrders = false;

    public function with(): array
    {
        $orders = (new OrderService($this))->req()->take(6)->get();
        $orders = $this->setPrettyOrdersIndexes($orders);

        $promotion = Setting::where('key', 'promotion')->first();
        $textPromotion = '';

        if ($promotion) {
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
            'productsCount' => Product::count(),
            'ordersCount' => Order::whereRelation('state', 'indice', '>', 3)
                                  ->whereRelation('state', 'indice', '<', 6)
                                  ->count(),
            'usersCount' => User::count(),
            'orders' => $orders->collect(),
            'promotion' => $promotion,
            'textPromotion' => $textPromotion,
            'headersOrders' => $this->headersOrders(),
        ];
    }
}; ?>

@section('title', content: __('Dashboard'))
<div>
    <x-collapse wire:model="openGlance" class="shadow-md">
        <x-slot:heading>
            @lang('In a glance')
        </x-slot:heading>
        <x-slot:content class="flex flex-wrap gap-4">
            <a href="/" class="flex-grow">
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

    @if(!is_null($promotion->value))
        <br>
        <x-alert title="{{ __('Global promotion') }} {{ $textPromotion }}" description="{{ __('From') }} {{ $promotion->date1->isoFormat('LL') }} {{ __('to') }} {{ $promotion->date2->isoFormat('LL') }} {{ __L('Percentage discount') }} {{ $promotion->value }}%" icon="o-currency-euro" class="alert-warning" >
            <x-slot:actions>
                <x-button label="{{ __('Edit') }}" class="btn-outline" link="{{ route('admin.products.promotion') }}" />
            </x-slot:actions>
        </x-alert>
    @endIf

    <x-header separator progress-indicator />

    <x-collapse wire:model="openOrders" class="shadow-md">
        <x-slot:heading>
            @lang('Latest orders')
        </x-slot:heading>

        <x-slot:content>
            <x-card class="mt-6" title="" shadow separator>
                @include('livewire.admin.orders.table')
                <x-slot:actions>
                    <x-button label="{{ __('See all orders') }}" class="btn-primary" icon="s-list-bullet"
                        link="{{ route('admin.orders.index') }}" />
                </x-slot:actions>
            </x-card>
        </x-slot:content>
    </x-collapse>
</div>

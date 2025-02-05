<?php

use App\Models\{ Order, Product, User };
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Traits\ManageOrders;

new
#[Title('Dashboard')]
#[Layout('components.layouts.admin')]
class extends Component
{
	use ManageOrders;

    public bool $openGlance = true;
    public bool $openOrders = true;
    public bool $paginationOrders = false;

    public function with(): array
	{
		return [
			'productsCount' => Product::count(),
			'ordersCount'   => Order::whereRelation('state', 'indice', '>', 3)
                                    ->whereRelation('state', 'indice', '<', 6)
                                    ->count(),
			'usersCount'    => User::count(),
            'orders'        => Order::with('user', 'state', 'addresses')
                                    ->when($this->sortBy['column'] === 'user', 
                                            function ($query) {
                                                $query->orderBy(function ($query) {
                                                    $query->selectRaw('COALESCE(
                                                        (SELECT company FROM order_addresses WHERE order_addresses.order_id = orders.id LIMIT 1),
                                                        (SELECT CONCAT(users.name, " ", users.firstname) 
                                                        FROM users 
                                                        WHERE users.id = orders.user_id)
                                                    )')
                                                    ->limit(1);
                                                }, $this->sortBy['direction']); 
                                            },
                                            function ($query) {
                                                $query->orderBy(...array_values($this->sortBy));
                                            }
                                    )->take(6)
                                    ->get(),
            'headersOrders' => $this->headersOrders(),
		];
	}

}; ?>

<div>
    <x-collapse wire:model="openGlance" class="shadow-md">
        <x-slot:heading>
            @lang('In a glance')
        </x-slot:heading>
        <x-slot:content class="flex flex-wrap gap-4">
            <a href="/" class="flex-grow">
                <x-stat
                    title="{{ __('Active products') }}"
                    description=""
                    value="{{ $productsCount }}"
                    icon="s-shopping-bag"
                    class="shadow-hover" />
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex-grow">
                <x-stat
                    title="{{ __('Successful orders') }}"
                    description=""
                    value="{{ $ordersCount }}"
                    icon="s-shopping-cart"
                    class="shadow-hover" />
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex-grow">
                <x-stat
                    title="{{ __('Customers') }}"
                    description=""
                    value="{{ $usersCount }}"
                    icon="s-user"
                    class="shadow-hover" />
            </a>
        </x-slot:content>
    </x-collapse>

    <x-header separator progress-indicator />
    <x-collapse wire:model="openOrders" class="shadow-md">
        <x-slot:heading>
            @lang('Latest orders')
        </x-slot:heading>
        <x-header
        class="my-0!important border-0 text-red-500"
        separator progress-indicator />

        <x-slot:content>
            <x-card class="mt-6" title="" shadow separator >
                @include('livewire.admin.orders.table')
                <x-slot:actions>
                    <x-button
                        label="{{ __('See all orders') }}"
                        class="btn-primary"
                        link="{{ route('admin.orders.index') }}" />
                </x-slot:actions>
            </x-card>
        </x-slot:content>
    </x-collapse>

</div>

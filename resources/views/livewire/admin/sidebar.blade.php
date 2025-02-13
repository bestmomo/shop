<?php

use Illuminate\Support\Facades\{Auth, Session};
use Livewire\Volt\Component;

new class() extends Component
{
	public function logout(): void
	{
		Auth::guard('web')->logout();

		Session::invalidate();
		Session::regenerateToken();

		$this->redirect('/');
	}
}; ?>

<div>
    <x-menu activate-by-route>
        <x-list-item :item="Auth::user()" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
            <x-slot:actions>
                <x-button icon="o-power" wire:click="logout" class="btn-circle btn-ghost btn-xs"
                tooltip-left="{{ __('Logout') }}" no-wire-navigate />
            </x-slot:actions>
        </x-list-item>
        <x-menu-separator />
        <x-menu-item title="{{ __('Dashboard') }}" icon="s-building-office-2" link="{{ route('admin') }}" />
        <x-menu-item title="{{ __('Orders') }}" icon="s-shopping-bag" link="{{ route('admin.orders.index') }}" />
        <x-menu-sub title="{{ __('Customers') }}" icon="s-users">
            <x-menu-item title="{{ __('Listing') }}" icon="s-list-bullet" link="{{ route('admin.customers.index') }}" />
            <x-menu-item title="{{ __('Addresses') }}" icon="c-map-pin" link="{{ route('admin.addresses') }}" />
        </x-menu-sub>
        <x-menu-item icon="s-building-storefront" title="{{ __('Catalog') }}" link="{{ route('admin.products.index') }}" />
        <x-menu-separator />
        <x-menu-sub title="{{ __('Settings') }}" icon="s-cog-8-tooth">
            <x-menu-item title="{{ __('Store') }}" icon="c-building-storefront" link="{{ route('admin.parameters.store') }}" />
            <x-menu-item title="{{ __('Order status') }}" icon="m-eye" link="{{ route('admin.parameters.states.index') }}" />
            <x-menu-item title="{{ __('Countries') }}" icon="c-map-pin" link="{{ route('admin.parameters.countries.index') }}" />
            <x-menu-item title="{{ __('Pages') }}" icon="o-document-duplicate" link="{{ route('admin.parameters.pages.index') }}" />
            <x-menu-sub title="{{ __('Shipments') }}" icon="s-truck">
                <x-menu-item title="{{ __('Ranges') }}" icon="o-circle-stack" link="{{ route('admin.parameters.shipping.ranges') }}" />
                <x-menu-item title="{{ __('Rates') }}" icon="s-currency-euro" link="{{ route('admin.parameters.shipping.rates') }}" />
            </x-menu-sub>
        </x-menu-sub>
        <x-menu-item title="{{ __('Maintenance') }}" icon="c-wrench-screwdriver" link="{{ route('admin.maintenance') }}" :class="App::isDownForMaintenance() ? 'bg-red-300' : ''" />
        <x-menu-item icon="m-arrow-right-end-on-rectangle" title="{{ __('Go on store') }}" link="/" />
        <x-menu-item>
            <x-theme-toggle />
        </x-menu-item>
        <x-menu-separator />
            <p class="text-right mr-3"><a href="{{ route('admin.test') }}" title=" {{ __('Test page') }} "><x-icon name="c-cog" /></a></p>
    </x-menu>
</div>

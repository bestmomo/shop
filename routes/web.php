<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

Volt::route('/', 'index')->name('home');
Volt::route('/pages/{page:slug}', 'page')->name('pages');
Volt::route('/products/{product}', 'product')->name('products.show');
Volt::route('/cart', 'cart')->name('cart');

Route::middleware('guest')->group(function () {
	Volt::route('/register', 'auth.register');
	Volt::route('/login', 'auth.login')->name('login');
	Volt::route('/forgot-password', 'auth.forgot-password');
	Volt::route('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

Route::middleware('auth')->group(function () {

	Route::prefix('order')->group(function () {
		Volt::route('/creation', 'order.index')->name('order.index');
		Volt::route('/confirmation/{id}', 'order.confirmation')->name('order.confirmation');
		Volt::route('/card/{id}', 'order.card')->name('order.card');
	});

	Route::prefix('account')->group(function () {
		Volt::route('/profile', 'account.profile')->name('profile');
		Volt::route('/rgpd', 'account.rgpd.index')->name('rgpd');
		Volt::route('/addresses', 'account.addresses.index')->name('addresses');
		Volt::route('/addresses/create', 'account.addresses.create')->name('addresses.create');
		Volt::route('/addresses/{address}/edit', 'account.addresses.edit')->name('addresses.edit');
		Volt::route('/orders', 'account.orders.index')->name('orders');
		Volt::route('/orders/{order}', 'account.orders.show')->name('orders.show');
	});

	Route::middleware(IsAdmin::class)->prefix('admin')->group(function ()
	{
		Volt::route('/dashboard', 'admin.index')->name('admin');
		Volt::route('/orders', 'admin.orders.index')->name('admin.orders.index');
		Volt::route('/orders/{order}', 'admin.orders.show')->name('admin.orders.show');
		Volt::route('/customers', 'admin.customers.index')->name('admin.customers.index');
		Volt::route('/customers/{user}', 'admin.customers.show')->name('admin.customers.show');
		Volt::route('/addresses', 'admin.customers.addresses')->name('admin.addresses');
		Volt::route('/products', 'admin.products.index')->name('admin.products.index');
		Volt::route('/products/create', 'admin.products.create')->name('admin.products.create');
		Volt::route('/products/{product}/edit', 'admin.products.edit')->name('admin.products.edit');
		Volt::route('/store', 'admin.parameters.store')->name('admin.parameters.store');
		Volt::route('/states', 'admin.parameters.states.index')->name('admin.parameters.states.index');
		Volt::route('/states/create', 'admin.parameters.states.create')->name('admin.parameters.states.create');
		Volt::route('/states/{state}/edit', 'admin.parameters.states.edit')->name('admin.parameters.states.edit');
	});
});

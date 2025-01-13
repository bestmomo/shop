<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Volt::route('/', 'index')->name('home');
Volt::route('/pages/{page:slug}', 'page')->name('pages');

Route::middleware('guest')->group(function () {
	Volt::route('/register', 'auth.register');
});

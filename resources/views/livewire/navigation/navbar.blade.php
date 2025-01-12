<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Auth, Session};
use Livewire\Volt\Component;
use Livewire\Attributes\On;
use Darryldecode\Cart\CartCollection;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

	public function logout(): void
	{
		Auth::guard('web')->logout();
		Session::invalidate();
		Session::regenerateToken();
		$this->redirect('/');
	}
};
?>

<x-nav sticky full-width :class="'bg-cyan-700 text-white'">

    <x-slot:brand>
        <label for="main-drawer" class="mr-3 lg:hidden">
            <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>

        <a href="/" wire:navigate>
            <x-app-brand />
        </a>
    </x-slot:brand>

    <x-slot:actions>
        <span class="hidden lg:block">
            @if ($user = auth()->user())
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button label="{{ $user->name }} {{ $user->firstname }}" class="btn-ghost" />
                    </x-slot:trigger>
                    <span class="text-black">
                        <x-menu-item title="{{ __('My profile') }}" link="" />
                        <x-menu-item title="{{ __('My addresses') }}" link="" />
                        <x-menu-item title="{{ __('My orders') }}" link="" />
                        <x-menu-item title="{{ __('RGPD') }}" link="" />
                        <x-menu-item title="{{ __('Logout') }}" wire:click="logout" />  
                    </span>                  
                </x-dropdown>
            @else
                <x-button label="{{ __('Login') }}" link="/login" class="btn-ghost" />
            @endif
        </span>
    </x-slot:actions>
</x-nav>
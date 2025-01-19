<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Auth, Session};
use Livewire\Volt\Component;
use Livewire\Attributes\On;
use Darryldecode\Cart\CartCollection;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public int $CartItems = 0;
    public CartCollection $content;
    public float $total;
    public string $url;

	public function mount(): void
	{
        $this->CartItems = Cart::getTotalQuantity();
        $this->content = Cart::getContent();
        $this->total = Cart::getTotal();
		$this->url = request()->url();
	}

	public function logout(): void
	{
		Auth::guard('web')->logout();
		Session::invalidate();
		Session::regenerateToken();
		$this->redirect('/');
	}

    public function cleanCart(): void
    {
        Cart::clear();
        $this->updateCartItems();
        $this->info(__('Cart cleaned.'), position: 'toast-bottom');
    }

    public function deleteItem($item): void
    {
        Cart::remove($item);
        $this->updateCartItems();
        $this->info(__('Item deleted.'), position: 'toast-bottom');
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
        @if($CartItems > 0 && $url !== route('cart'))
        <x-dropdown>
            <x-slot:trigger>
                <x-button label="{{ __('Cart') }}" icon="o-shopping-cart" badge="{{ $CartItems }}" badge-classes="badge-ghost" class="btn-ghost" />
            </x-slot:trigger>                                 
            <div class="p-2 text-black {{ $content->isNotEmpty()? 'min-w-[300px]' : '' }}">
                @foreach ($content as $item)
                    <div class="flex justify-between mb-2">
                        <div class="flex gap-4">
                            <img class="object-cover w-14 h-14" src="{{ asset('storage/photos/' . $item->attributes->image) }}" alt="{{ $item->name }}" />
                            <div class="mt-2">
                                <span class="font-bold">{{ $item->name }}</span><br>
                                {{ number_format($item->quantity * $item->price, 2, ',', ' ') }} €
                                <br>@lang('Quantity:') {{ $item->quantity }}
                            </div>
                        </div>
                        <x-button icon="o-trash" wire:click="deleteItem({{ $item->id }})" class="text-red-500 btn-circle btn-ghost btn-sm" />
                    </div>
                    <hr><br>
                @endforeach                
                <br>
                <div class="flex justify-between items-center mb-1">
                    <div class="font-bold">
                        @if($CartItems > 1)
                            @lang('Total of my') {{ $CartItems }} @lang('articles')
                        @else
                            @lang('Total of my article') 
                        @endif
                    </div>
                    <div class="font-bold">{{ number_format($total, 2, ',', ' ') }} € TTC</div>
                </div>
                <p class="mb-4 text-right"><em>@lang('Excluding delivery')</em></p>
                <hr>
                <div class="flex gap-2 justify-between items-center mt-4">
                    <x-button label="{{ __('Trash my cart') }}" wire:click="cleanCart" class="text-red-500 btn-ghost btn-sm" />
                    <x-button label="{{ __('View my cart') }}" link="{{ route('cart') }}" icon-right="c-arrow-right" class="btn-primary btn-sm" />
                </div>
            </div>
        </x-dropdown>
        @endif
        <span class="hidden lg:block">
            @if ($user = auth()->user())
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button label="{{ $user->name }} {{ $user->firstname }}" class="btn-ghost" />
                    </x-slot:trigger>
                    <span class="text-black">
                        <x-menu-item title="{{ __('My profile') }}" link="{{ route('profile') }}" />
                        <x-menu-item title="{{ __('My addresses') }}" link="{{ route('addresses') }}" />
                        <x-menu-item title="{{ __('My orders') }}" link="{{ route('orders') }}" />
                        <x-menu-item title="{{ __('RGPD') }}" link="{{ route('rgpd') }}" />
                        <x-menu-item title="{{ __('Logout') }}" wire:click="logout" />  
                    </span>                  
                </x-dropdown>
            @else
                <x-button label="{{ __('Login') }}" link="/login" class="btn-ghost" />
            @endif
        </span>
    </x-slot:actions>
</x-nav>

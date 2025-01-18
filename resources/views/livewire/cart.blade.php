<?php

use Livewire\Volt\Component;
use Darryldecode\Cart\CartCollection;

new class extends Component {
    public int $CartItems = 0;
    public CartCollection $content;
    public float $total;
    public array $quantities = [];

    public function mount(): void
    {
        $this->refreshCart();
        foreach ($this->content as $item) {
            $this->quantities[$item->id] = $item->quantity;
        }
    }

    public function updateQuantity($itemId)
    {
        Cart::update($itemId, [
            'quantity' => ['relative' => false, 'value' => $this->quantities[$itemId]],
        ]);
        $this->refreshCart();
    }

    public function deleteItem($itemId)
    {
        Cart::remove($itemId);
        $this->refreshCart();
    }

    public function cleanCart(): void
    {
        Cart::clear();
        $this->refreshCart();
    }

    private function refreshCart(): void
    {
        $this->CartItems = Cart::getTotalQuantity();
        $this->content = Cart::getContent();
        $this->total = Cart::getTotal();
        $this->dispatch('cart-updated'); 
    }
}; ?>

<div class="flex justify-center mt-6">

    <x-card class="w-full md:w-3/4" title="{{ __('My cart') }}" shadow separator progress-indicator>   
        @if(session()->has('message'))
            <x-alert title="{{ trans(session('message')) }}" icon="o-exclamation-triangle" class="alert-warning" /><br>
        @endif
        @foreach ($content as $item)
            <div class="flex justify-between items-center">
                <div class="flex gap-4 justify-between items-center mt-2">
                    <img class="w-[60px]" src="{{ asset('storage/photos/' . $item->associatedModel->image) }}" alt="" />
                    <div>
                        <span class="font-bold">{{ $item->name }}</span><br>
                        {{ number_format($item->quantity * $item->price, 2, ',', ' ') }} €
                    </div>
                </div>
                <div class="flex gap-2 justify-between items-center">
                    <x-input class="!w-[80px]" wire:model="quantities.{{ $item->id }}" type="number" min="1" wire:change="updateQuantity({{ $item->id }})" />
                    <x-button icon="o-trash" wire:click="deleteItem({{ $item->id }})"
                    class="text-red-500 btn-circle btn-ghost" />
                </div>
            </div>
            <br>
            <hr>
        @endforeach
        @if ($content->isNotEmpty())
            <br>
            <div class="flex justify-between items-center">
                <div>
                    @if($CartItems > 1)
                        @lang('Total of my') {{ $CartItems }} @lang('articles')
                    @else
                        @lang('Total of my article') 
                    @endif
                </div>
                <div class="font-bold">{{ number_format($total, 2, ',', ' ') }} € TTC </div>                
            </div>
            <div class="flex justify-end mb-4">
                <em>@lang('Excluding delivery')</em>
            </div>
            <hr>
            <div class="flex justify-between items-center mt-4">
                <x-button label="{{ __('Trash my cart') }}" wire:click="cleanCart" icon="o-trash"
                    class="text-red-500 btn-ghost btn-sm" />
                <x-button label="{{ auth()->check() ? __('I order') : __('Log in to order') }}" icon-right="c-arrow-right" link="" class="btn-primary btn-sm" />
            </div>
        @else
            @lang('The cart is empty.')
        @endif
    </x-card>
</div>
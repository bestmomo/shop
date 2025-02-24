<?php

use Livewire\Volt\Component;
use App\Models\Product;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public Product $product;
    public int $quantity = 1;
    public bool $hasPromotion = false;
    public float $bestPrice = 0;

    public function mount(Product $product): void
    {
        if (!$product->active) {
            abort(404);
        }

        $this->product = $product;

        $this->bestPrice = getBestPrice($product);
        $this->hasPromotion = $this->bestPrice < $product->price;
    }

    public function save(): void
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->bestPrice,
            'quantity' => $this->quantity,
            'attributes' => ['image' => $this->product->image],
            'associatedModel' => $this->product,
        ]);

        $this->dispatch('cart-updated');

        $this->info(__('Product added to cart.'), position: 'bottom-end');
    }
}; ?>

<div class="container p-5 mx-auto">
    <div class="grid gap-10 lg:grid-cols-2">
        <div>
            <img class="mx-auto" src="{{ asset('storage/photos/' . $product->image) }}" alt="{{ $product->name }}" />
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $product->name }}</div>
            @if($hasPromotion)
                <x-badge class="p-3 my-4 mr-2 badge-error font-bold" value="{{ ftA($bestPrice) }} {{ __('VAT') }}" />
            @endif
            <x-badge class="p-3 my-4 badge-neutral {{ $hasPromotion ? 'line-through' : '' }}" value="{{ ftA($product->price) }} {{ __('VAT') ?? '' }}" value="{{ ftA($product->price) }} {{ __('VAT') }}" />

            <p class="mb-4">{{ $product->description }}</p>
            <x-input class="!w-[80px]" wire:model="quantity" type="number" min="1" label="{{ __('Quantity')}}" />
            <x-button class="mt-4 btn-primary" wire:click="save" icon="o-shopping-cart" spinner >{{ __('Add to cart')}}</x-button>
        </div>
    </div>
</div>

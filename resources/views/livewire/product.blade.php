<?php

use Mary\Traits\Toast;
use App\Models\Product;
use App\Services\Marketing;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    public Product $product;
    public int $quantity = 1;
    public bool $hasPromotion = false;
    public $bestPrice;

    public function mount(Product $product): void
    {
        if (!$product->active) {
            abort(404);
        }

        $this->product = $product;

        $this->bestPrice = (new Marketing())->bestPrice($product);
        // $this->hasPromotion = $this->bestPrice < $product->price;
    }

    public function save(): void
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->bestPrice->amount,
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
            <x-public-product-prices :bestPrice=$bestPrice />
            <p class="mb-4">{{ $product->description }}</p>
            <x-input class="!w-[80px]" wire:model="quantity" type="number" min="1" label="{{ __('Quantity') }}" />
            <x-button class="mt-4 btn-primary" wire:click="save" icon="o-shopping-cart"
                spinner>{{ __('Add to cart') }}</x-button>
        </div>
    </div>
</div>

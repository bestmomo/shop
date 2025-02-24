<?php

use Livewire\Volt\Component;
use App\Models\{Product, Setting};

new class extends Component {
    public function with(): array
    {
        return [
            'products' => Product::whereActive(true)->get(),
        ];
    }
}; ?>

@section('title', __('Home'))
<div class="container mx-auto">
    @if (session('registered'))
        <x-alert title="{!! session('registered') !!}" icon="s-rocket-launch" class="mb-4 alert-info" dismissible />
    @endif
    <x-card class="w-full shadow-md shadow-gray-500" shadow separator>
        {!! $shop->home !!}
    </x-card>
    <br>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($products as $product)
            @php
                $bestPrice = getBestPrice($product);
                if ($bestPrice === $product->price) {
                    $titleContent =
                        '<span class="">' .
                        number_format($product->price, 2, ',', ' ') .
                        ' € TTC</span>';
                } else {
                    $titleContent =
                        '<span class="line-through">' .
                        number_format($product->price, 2, ',', ' ') .
                        ' € TTC</span> <span class="text-red-500">' .
                        number_format($bestPrice, 2, ',', ' ') .
                        ' € TTC</span>';
                }
            @endphp
            <x-card
                class="shadow-md transition duration-500 ease-in-out shadow-gray-500 hover:shadow-xl hover:shadow-gray-500 flex flex-col justify-between">
                    {!! $titleContent !!}<br>
                    <b>{!! $product->name !!}</b>
                    @unless ($product->quantity)
                    <br><span class="text-red-500">@lang('Product out of stock')</span>
                    @endunless

                @if ($product->image)
                    <x-slot:figure>
                        @if ($product->quantity)
                            <a href="{{ route('products.show', $product) }}">
                        @endif
                        <img src="{{ asset('storage/photos/' . $product->image) }}" alt="{!! $product->name !!}" />
                        @if ($product->quantity)
                            </a>
                        @endif
                    </x-slot:figure>
                @endif
            </x-card>
        @endforeach
    </div>
    <br>
    <x-card class="w-full shadow-md shadow-gray-500" shadow separator>
        <x-accordion class="shadow-md shadow-gray-500">
            <x-collapse name="group1">
                <x-slot:heading>{{ __('General informations') }}</x-slot:heading>
                <x-slot:content>{!! $shop->home_infos !!}</x-slot:content>
            </x-collapse>
            <x-collapse name="group2">
                <x-slot:heading>{{ __('Shipping charges') }}</x-slot:heading>
                <x-slot:content>{!! $shop->home_shipping !!}</x-slot:content>
            </x-collapse>
        </x-accordion>
    </x-card>
</div>

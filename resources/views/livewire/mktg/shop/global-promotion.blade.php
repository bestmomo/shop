<?php
include_once 'global-promotion.php';
?>

<div class='text-center w-6/12 mx-auto'>
    @if (!is_null($promotion->value))

        {{-- @dump($promotion) --}}

        <x-alert title="{{ __('Global promotion') }} {{ $promotion->text }}"
            description="{{ __('From') }} {{ $promotion->date1->isoFormat('LL') }} {{ __('to') }} {{ $promotion->date2->isoFormat('LL') }} {{ __L('Percentage discount') }} {{ $promotion->value }}%"
            icon="o-currency-euro" class="alert-info text-center">
            @if ($target === 'back')
                <x-slot:actions>
                    <x-button label="{{ __('Edit') }}" class="btn-outline text-black"
                        link="{{ route('admin.products.promotion') }}" />
                </x-slot:actions>
            @else
                <x-slot:actions>
                    <x-button label="{{ __('Enjoy it!') }}" class='btn-outline cursor-default rounded' />
                </x-slot:actions>
            @endif
        </x-alert>
    @endIf
</div>

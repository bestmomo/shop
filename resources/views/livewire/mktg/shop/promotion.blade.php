<?php
include_once 'promotion.php';
?>

<div>

    {{-- <x-header title="{{ __('Promotion') }} - {{ ucfirst($target) }}" separator progress-indicator /> --}}

    @if (!is_null($promotion->value) && $target==='back')
        <br>
        {{-- @dump($promotion) --}}
        <x-alert title="{{ __('Global promotion') }} {{ $promotion->text }}"
            description="{{ __('From') }} {{ $promotion->date1->isoFormat('LL') }} {{ __('to') }} {{ $promotion->date2->isoFormat('LL') }} {{ __L('Percentage discount') }} {{ $promotion->value }}%"
            icon="o-currency-euro" class="alert-warning">
            <x-slot:actions>
                <x-button label="{{ __('Edit') }}" class="btn-outline"
                    link="{{ route('admin.products.promotion') }}" />
            </x-slot:actions>
        </x-alert>
    @endIf
</div>

<?php

use Mary\Traits\Toast;
use App\Models\Product;
use App\Services\Marketing;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Title};

new #[Layout('components.layouts.admin')] class extends Component {
    use Toast, WithPagination;

    public array $sortBy = [
        'column' => 'name',
        'direction' => 'asc',
    ];

    public int $perPage = 10;

    public function headers(): array
    {
        return [['key' => 'image', 'label' => __('Image')], ['key' => 'name', 'label' => __('Name')], ['key' => 'price', 'label' => __('Price incl. VAT'), 'class' => 'text-right'], ['key' => 'active', 'label' => __('Active'), 'class' => 'text-center'], ['key' => 'promotion_price', 'label' => __('Promotion'), 'class' => 'text-center'], ['key' => 'quantity', 'label' => __('Quantity'), 'class' => 'text-right']];
    }

    public function mount()
    {
        $this->global_promotion = (new Marketing())->globalPromotion();
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
        $this->success(__('Product deleted successfully.'));
    }

    public function updated($property): void
    {
        if (!is_array($property) && $property != '') {
            $this->resetPage();
        }
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'products' => Product::orderBy(...array_values($this->sortBy))->paginate($this->perPage),
            'global_promotion' => $this->global_promotion,
        ];
    }
}; ?>

@section('title', __('Catalog'))
<div>
    <x-header title="{{ __('Catalog') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
            <x-button icon="o-currency-euro" label="{!! __('Global promotion') !!}" link="/admin/products/promotion" spinner
                class="btn-success" />
            <x-button icon="o-plus" label="{!! __('Create a new product') !!}" link="/admin/products/create" spinner
                class="btn-primary" />
        </x-slot:actions>
    </x-header>

    @livewire('mktg.shop.global-promotion', ['promotion' => $global_promotion, 'target' => 'back'])

    <x-card class='mt-6'>
        <x-table striped :headers="$headers" :rows="$products" :sort-by="$sortBy" per-page="perPage" with-pagination
            link="/admin/products/{id}/edit">

            @scope('cell_image', $product)
                <img src="{{ asset('storage/photos/' . $product->image) }}" width="60" alt="">
            @endscope

            @scope('cell_price', $product)
                @php
                    // if ($loop->index == 0) {
                        $marketing = new Marketing();
                        // Debugbar::info($loop);
                        // $product->best_price = $marketing->bestPrice();
                        // $uuu = $product->price;
                        $bestPrice = $marketing->bestPrice($product);
                    // }
                @endphp

                {{ ftA($product->price) }}<br>
                {{ $bestPrice->amount ?? null}}<br>
                {{ $bestPrice->origin ?? null}}
                {{ $bestPrice->origin ?? null}}
            @endscope

            @scope('cell_active', $product)
                @if ($product->active)
                    <x-icon name="o-check-circle" class='text-green-400 w-7' />
                @else
                    <x-icon name="o-x-circle" class='text-orange-400 w-7' />
                @endif
            @endscope

            @scope('cell_promotion_price', $product)
                @if ($product->promotion_price)
                    @if (now()->isBefore($product->promotion_start_date))
                        <x-badge class="p-3 my-4 badge-info" value="{{ trans('Coming soon') }}" />
                    @elseif(now()->between($product->promotion_start_date, $product->promotion_end_date))
                        <x-badge class="p-3 my-4 badge-success" value="{{ trans('In promotion') }}" />
                    @else
                        <x-badge class="p-3 my-4 badge-error" value="{{ trans('Expired') }}" />
                    @endIf
                    <span
                        class="{{ now()->between($product->promotion_start_date, $product->promotion_end_date) ? 'text-red-500' : '' }} ml-2">
                        {{ ftA($product->best_price) }}
                    </span>
                    <br>
                    <span class="whitespace-nowrap">
                        {{ $product->promotion_start_date->isoFormat('LL') }} -
                        {{ $product->promotion_end_date->isoFormat('LL') }}
                    </span>
                @endif
            @endscope

            @scope('cell_quantity', $product)
                @if ($product->quantity < $product->quantity_alert)
                    <x-badge class="p-3 my-4 badge-error" value="{{ bigR($product->quantity, 0) }}" />
                @else
                    {{ bigR($product->quantity, 0) }}
                @endif
            @endscope

            @scope('actions', $product)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="deleteProduct({{ $product->id }}"
                            wire:confirm="{{ __('Are you sure you want to delete this product?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>
</div>

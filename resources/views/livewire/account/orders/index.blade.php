<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;

new #[Title('Orders')]
class extends Component {

    public function headers(): array
	{
		return [
            ['key' => 'reference', 'label' => __('Reference')], 
            ['key' => 'date', 'label' => __('Date')],
            ['key' => 'amount', 'label' => __('Amount')],
            ['key' => 'state', 'label' => __('State')],
        ];
	}

    public function with(): array
    {
        return [
            'orders' => Auth::user()->orders()->latest()->with('state')->get(),
            'headers' => $this->headers(),
        ];
    }

}; ?>

<div>
    <x-card class="flex justify-center items-center mt-6" title="{{ __('My orders') }}" shadow separator >
        <x-table striped :headers="$headers" :rows="$orders" link="/account/orders/{id}" >
            @scope('cell_date', $order)
                {{ $order->created_at->isoFormat('LL') }}
            @endscope
            @scope('cell_amount', $order)
                {{ number_format($order->total_order, 2, ',', ' ') }} €
            @endscope
            @scope('cell_state', $order)
                <x-badge value="{{ $order->state->name }}" class="p-3 bg-{{ $order->state->color }}-400" />
            @endscope
        </x-table>
    </x-card>    
</div>

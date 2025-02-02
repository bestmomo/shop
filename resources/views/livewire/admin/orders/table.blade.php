<x-card>
    <x-table 
        striped 
        :headers="$headersOrders" 
        :rows="$orders" 
        :sort-by="$sortBy" 
        per-page="perPage"
        :with-pagination="$paginationOrders"
        link="/admin/orders/{id}"
    >
        @scope('cell_user', $order)
            {{ $order->addresses->first()->company? $order->addresses->first()->company :  $order->user->name . ' ' . $order->user->firstname }}
        @endscope
        @scope('cell_created_at', $order)
            <span class="whitespace-nowrap">
                {{ $order->created_at->isoFormat('LL') }}
                @if(!$order->created_at->isSameDay($order->updated_at))
                    <p>@lang('Change') : {{ $order->updated_at->isoFormat('LL') }}</p>
                @endif
            </span>
        @endscope
        @scope('cell_total', $order)
            <span class="whitespace-nowrap">
                {{ $order->total }} €
            </span>
        @endscope
        @scope('cell_state', $order)
            <x-badge value="{{ $order->state->name }}" class="p-3 bg-{{ $order->state->color }}-400 whitespace-nowrap" />
        @endscope
        @scope('cell_reference', $order)
            <strong>{{ $order->reference }}</strong>
        @endscope
        @scope('cell_invoice_id', $order)
            @if ($order->invoice_id)
                <x-icon name="o-check-circle" />
            @endif
        @endscope
    </x-table>
</x-card>

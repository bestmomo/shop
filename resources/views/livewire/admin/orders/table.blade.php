<x-card>
    <x-table striped :headers="$headersOrders" :rows="$orders" :sort-by="$sortBy" per-page="perPage" :with-pagination="$paginationOrders"
        link="/admin/orders/{id}">
        @scope('cell_id', $order)
            <span class="whitespace-nowrap">
                <b>{{ $order->orderId }}</b class='text-xl'>
            </span>
        @endscope
        @scope('cell_user', $order)
            {{ $order->addresses->first()->company ?? $order->user->name . ' ' . $order->user->firstname }}
        @endscope
        @scope('cell_created_at', $order)
            <span class="whitespace-nowrap">
                {{ $order->created_at->isoFormat('LL') }}
                @if (!$order->created_at->isSameDay($order->updated_at))
                    <p>@lang('Change') : {{ $order->updated_at->isoFormat('LL') }}</p>
                @endif
            </span>
        @endscope
        @scope('cell_total', $order)
            <div class="whitespace-nowrap text-right pr-7">
                {{ number_format($order->total, 2, ',', ' ') }} €
            </div>
        @endscope
        @scope('cell_state', $order)
            <x-badge value="{{ $order->state->name }}" class="p-3 bg-{{ $order->state->color }}-400 whitespace-nowrap" />
        @endscope
        @scope('cell_reference', $order)
            <strong>{{ $order->reference }}</strong>
        @endscope
        @scope('cell_invoice_id', $order)
            @if ($order->invoice_id)
                @if ($order->state_id > 5)
                    <x-icon name="o-check-circle" />
                @endif
                <span class ="whitespace-nowrap">
                    @lang(key: '#') {{ $order->invoiceId }}
                </span>
            @endif
        @endscope
    </x-table>
</x-card>

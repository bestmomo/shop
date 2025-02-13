<x-card>
    {{-- //2do hover Client → id, name, firstname+société-addr used --}}
    <x-table striped :headers="$headersOrders" :rows="$orders" :sort-by="$sortBy" per-page="perPage" :with-pagination="$paginationOrders"
        link="/admin/orders/{id}">

        @scope('header_id', $header)
            <span class='inline-block'>
                <x-popover>
                    <x-slot:trigger>
                        {{ $header['label'] }}
                        <x-slot:content class="pop-small text-cyan-400">
                            @lang('Sort by the last 6 digits')
                        </x-slot:content>
                    </x-slot:trigger>
                </x-popover>
            </span>
        @endscope

        @scope('header_invoice_id', $header)
            <span class='inline-block'>
                <x-popover>
                    <x-slot:trigger>
                        {{ $header['label'] }}
                        <x-slot:content class="pop-small">
                            @lang('Sort by the last 6 digits')
                        </x-slot:content>
                    </x-slot:trigger>
                </x-popover>
            </span>
        @endscope

        @scope('cell_id', $order)
            <div class='whitespace-nowrap'>
                {{ $order->orderId }}
            </div>
        @endscope

        @scope('cell_reference', $order)
            {{ $order->reference }}
        @endscope

        @scope('cell_user', $order)
            <x-popover>
                <x-slot:trigger>
                    {{ $order->addresses->first()->company ?? $order->user->name . ' ' . $order->user->firstname }}
                    <x-slot:content class="pop-small">
                        @lang('Delivery address'):<br>
                        <x-address :address="$order->addresses->last()" />
                    </x-slot:content>
                </x-slot:trigger>
            </x-popover>
        @endscope

        @scope('cell_total', $order)
            <div class="text-right whitespace-nowrap pr-7">
                {{ number_format($order->totalOrder, 2, ',', ' ') }} €
            </div>
        @endscope

        @scope('cell_created_at', $order)
            <span class="whitespace-nowrap">
                {{ $order->created_at->isoFormat('LL') }}
                @if (!$order->created_at->isSameDay($order->updated_at))
                    <p>@lang('Up') : {{ $order->updated_at->isoFormat('LL') }}</p>
                @endif
            </span>
        @endscope

        @scope('cell_state', $order)
            <x-badge value="{{ $order->state->name }}"
                class="p-3 bg-{{ $order->state->color }}-400 text-black whitespace-nowrap" />
        @endscope

        @scope('cell_invoice_id', $order)
            @if ($order->invoice_id)
                <table>
                    <td>
                        @if ($order->state_id > 5)
                            <x-icon name="o-check-circle" class="text-green-400" />
                        @else
                            <x-icon name="o-clock" class="text-orange-400" />
                        @endif
                    </td>
                    <td>
                        <span class ="whitespace-nowrap">
                            @lang(key: '#') {{ $order->invoiceId }}
                        </span>
                    </td>
                </table>
            @endif
        @endscope

    </x-table>
</x-card>

@php
    $delivery = $order->addresses->last();
@endphp

<div>
    {{-- <div class='border-2 border-cyan-400 mb-12 rounded-lg py-1 px-2'> --}}
        @lang('Delivery address'):<br>
        <b>{{ $delivery->professionnal ? $delivery->company : $delivery->civility . '. ' . $delivery->firstname . ' ' . strtoupper($delivery->name) }}</b><br>

        @if ($delivery->bp)
            BP @lang('#'){{ $delivery->bp }}<br>
        @endif
        {{ $delivery->address }}<br>
        @if ($delivery->addressbis)
            {{ $delivery->addressbis }}<br>
        @endif
        {{ $delivery->postal }} - <b>{{ strtoupper($delivery->city) }}</b>
        <hr>
        <x-icon name="m-phone" class="text-green-400" />{{ $delivery->phone }}<br>

        {{-- @dump($order->addresses->last()) --}}

    {{-- </div> --}}
</div>

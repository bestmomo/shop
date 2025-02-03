<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

new #[Title('Order confirmation')]
class extends Component {

    public Order $order;

    public function mount($id): void
    {
        $this->order = Order::with('products', 'addresses', 'state')->findOrFail($id);

        if (Auth::user()->id != $this->order->user_id) {
            abort(403);
        }
    }

}; ?>

<div>
    <x-card
        class="flex items-center justify-center mt-6 bg-gray-100 w-full lg:max-w-[80%] lg:mx-auto" title="{{ trans('Your order is confirmed') }}" shadow separator>
        <x-elements :order="$order" />
        <br>
        <x-card class="w-full sm:min-w-[50vw]" title="" shadow separator >
            @if($order->state->slug === 'cheque')
                <p>{{ trans('Please send us a check with:') }}</p>
                <ul>
                    <li>- {{ transL('Amount of payment:') }} <strong>{{ number_format($order->total + $order->shipping, 2, ',', ' ') }} €</strong></li>
                    <li>- {{ transL('Payable to the order of') }} <strong>{{ $shop->name }}</strong></li>
                    <li>- {{ transL('To be sent to') }} <strong>{{ $shop->address }}</strong></li>
                    <li>- {{ transL('Do not forget to indicate your order reference') }} <strong>{{ $order->reference }}</strong></li>
                </ul>
                <p>{{ $order->pick? trans('You can come and pick up your order as soon as the payment is received.') : trans('Your order will be shipped as soon as the payment is received.') }}</p>

            @elseif($order->state->slug === 'mandat')
                <p>{{ trans('You have chosen to pay by administrative mandate. This type of payment is reserved for administrations.') }}</p>
                <p>{{ trans('You must send your administrative mandate to:') }}</p>
                <p><strong>{{ $shop->name }}</strong></p>
                <p><strong>{{ $shop->address }}</strong></p>
                <p>{{ trans('You can also send it to us by email at this address:') }} <strong>{{ $shop->email }}</strong></p>
                <p>{{ trans('Do not forget to indicate your order reference') }} <strong>{{ $order->reference }}</strong>.</p>
                <p>{{ $order->pick ? trans('You can come and pick up your order as soon as the mandate is received.') : trans('Your order will be shipped as soon as this mandate is received.') }}</p>

            @elseif($order->state->slug === 'virement')
                <p>{{ trans('Please make a transfer to our account:') }}</p>
                <ul>
                    <li>- {{ transL('Amount of transfer:') }} <strong>{{ number_format($order->total + $order->shipping, 2, ',', ' ') }} €</strong></li>
                    <li>- {{ transL('Account holder:') }} <strong>{{ $shop->holder }}</strong></li>
                    <li>- {{ trans('BIC:') }} <strong>{{ $shop->bic }}</strong></li>
                    <li>- {{ trans('IBAN:') }} <strong>{{ $shop->iban }}</strong></li>
                    <li>- {{ transL('Bank:') }} <strong>{{ $shop->bank }}</strong></li>
                    <li>- {{ transL('Bank address:') }} <strong>{{ $shop->bank_address }}</strong></li>
                    <li>- {{ transL('Do not forget to indicate your order reference') }} <strong>{{ $order->reference }}</strong></li>
                </ul>
                <p>{{ $order->pick ? trans('You can come and pick up your order as soon as the payment is received.') : trans('Your order will be shipped as soon as the transfer is received.') }}</p>

            @endif
        </x-card>
    </x-card>
</div>

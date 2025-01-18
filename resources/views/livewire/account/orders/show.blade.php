<?php

use App\Models\Order;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;

new #[Title('Show order')]
class extends Component {

    public Order $order;

    public function mount(Order $order): void
    {
        if(auth()->user()->id != $order->user_id) {
            abort(403);
        }
        
        $this->order = $order;
    }

    public function invoice()
    {
        // Todo : send invoice
    }

}; ?>

<div>
    <x-card class="flex justify-center items-center mt-6 bg-gray-100" title="{{ __('Details of my order') }}" shadow separator >
        <x-elements :order="$order" />
        <br>
        <x-card class="w-full sm:min-w-[50vw]" title="{{ __('State') }}" shadow separator progress-indicator >
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <p class="mb-2 sm:mb-0 sm:mr-4"><strong>@lang('Payment method') :</strong> {{ $order->payment_text }}</p>
                <x-badge value="{{ $order->state->name }}" class="p-3 bg-{{ $order->state->color }}-400 self-start sm:self-center" />                
            </div>            
            @if($order->state->slug === 'carte' || $order->state->slug === 'erreur')
                <br>
                <x-alert title="{!! __('You were unable to make your credit card payment.') !!}" description="{{ __('Please contact us.') }}" icon="o-exclamation-triangle" class="alert-warning" />
            @endif
            @if($order->invoice_id)
                <br>
                <x-button label="{{ __('Download invoice') }}" wire:click="invoice" class="btn-outline" spinner />
            @endif
        </x-card>
        <x-slot:actions>
            <x-button label="{{ __('Back to orders') }}" class="btn-outline" link="{{ route('orders') }}" icon="c-arrow-long-left" wire:/>
        </x-slot:actions>
    </x-card>
</div>

<x-card class="w-full sm:min-w-[50vw]" title="{{ __('References') }}" shadow separator >
    <p><strong>Commande n° {{ $order->reference }}</strong></p>
    @if($order->purchase_order)
        <p><strong>Bon de commande n° {{ $order->purchase_order }}</strong></p>
    @endif
    <p><strong>Date :</strong> {{ $order->created_at->calendar() }}</p>
</x-card>
<br>
<x-card class="w-full sm:min-w-[50vw]" title="{{ __('Products') }}" shadow separator >
    <x-details 
        :content="$order->products" 
        :shipping="$order->shipping" 
        :tax="$order->tax" 
        :total="$order->total"
        :pick="$order->pick"
    />
</x-card>
<br>
<x-card class="w-full sm:min-w-[50vw]" shadow separator >
    <x-card class="w-full sm:min-w-[50vw]" title="{{ __('Billing address') }} {{ $order->addresses->count() === 1 && !$order->pick ? __('and delivery') : '' }}" shadow separator >
        <x-address :address="$order->addresses->first()" />
    </x-card>
        @if($order->pick)
            <x-alert title="{!! __('I chose to pick up my order on site.') !!}" icon="o-exclamation-triangle" class="mt-2 alert-info" />
        @else
            @if($order->addresses->count() === 2)
                <x-card class="w-full sm:min-w-[50vw]" title="{{ __('Delivery address') }}" shadow separator >
                    <x-address :address="$order->addresses->get(1)" />  
                </x-card>
            @endif              
        @endif
</x-card>

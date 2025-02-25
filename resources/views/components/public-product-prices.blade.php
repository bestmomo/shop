{{ Debugbar::addMessage(json_encode(get_object_vars($bestPrice)), 'CMPNT PRICES') }}

@if ( $bestPrice->amount < $bestPrice->normal )
<x-badge class="p-3 my-4 mr-2 badge-error font-bold rounded" value="{{ ftA($bestPrice->amount) . ' ' . __('VAT') }}" />
@endif
<x-badge class="p-3 my-4 rounded{{ $bestPrice->amount < $bestPrice->normal  ? ' line-through' : ''}}" value="{{ ftA($bestPrice->normal) . ' ' . __('VAT') }}" />
<br>


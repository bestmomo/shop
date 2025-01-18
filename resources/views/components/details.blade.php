@foreach ($content as $item)
  <div class="flex justify-between">
    <div>
      {{ $item->name }} ({{ $item->quantity }})
    </div>
    <div><strong>{{ number_format($item->total_price_gross ?? ($tax > 0 ? $item->price : price_without_vat($item->price)) * $item->quantity, 2, ',', ' ') }} €</strong></div>
  </div>
  <br><hr><br>
@endforeach
@unless($pick)
  <div class="flex justify-between p-3">
    <div>
      @lang('Colissimo delivery')
    </div>
    <div>
      <strong>{{ number_format($shipping, 2, ',', ' ') }} €</strong>
    </div>
  </div>
@endif
@if($tax > 0)
  <div class="flex justify-between p-3">
    <div>
      @lang('VAT to ') {{ $tax * 100 }}%
    </div>
    <div>
      <strong>{{ number_format($total / (1 + $tax) * $tax, 2, ',', ' ') }} €</strong>
    </div>
  </div>
@endif
<div class="flex justify-between p-3">
  <div>
    @lang('Total incl. VAT')
  </div>
  <div>
    <strong>{{ number_format($total + $shipping, 2, ',', ' ') }} €</strong>
  </div>
</div>
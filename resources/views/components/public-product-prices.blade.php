{{ Debugbar::addMessage(json_encode(get_object_vars($bestPrice)), 'CMPNT PRICES') }}


{{-- {{ $bestPrice->amount < $bestPrice->normal  ? 'line-through' : ''}}<br> --}}

<span class="text-red-500 text-xl mr-3 font-bold">{{ ftA($bestPrice->amount) . ' ' . __('VAT') }}</span>
<a class="text-blue-500{{ $bestPrice->amount < $bestPrice->normal  ? ' line-through' : ''}}"><span>{{ ftA($bestPrice->normal) . ' ' . __('VAT') }}</span></a>
{{-- <span class="text-blue-500" @class("span {{ $bestPrice->amount < $bestPrice->normal ? 'line-through' : '' }}")>{{ ftA($bestPrice->normal) . ' ' . __('VAT') }}</span> --}}
{{-- <span class={$priceStyle}>" . ftA($product->price) . ' ' . __('VAT') . '</span> --}}
<br>
<!--

$titleContent = '';
                $priceStyle = '';
                //2do repenser le systèmes des promotions... Un Model à part entière...?

                // if ($bestPrice < $product->price && $product->promotion_end_date) {
                //     $tooltip =
                //         __('Until') .
                //         ' ' .
                //         ($product->promotion_end_date->format('d') .
                //             ' ' .
                //             trans($product->promotion_end_date->format('F'))) .
                //         ' !';
                // }
                // if ($bestPrice < $product->price) {
                //     $priceStyle = 'line-through';
                //     $titleContent =
                //         '<a title="' .
                //         ($tooltip ?? '') .
                //         '"><span class="text-red-500 text-xl mr-3 font-bold">' .
                //         ftA($bestPrice) .
                //         ' ' .
                //         __('VAT') .
                //         '</span></a>';
                // }
                // $titleContent .= "<span class={$priceStyle}>" . ftA($product->price) . ' ' . __('VAT') . '</span>';


-->

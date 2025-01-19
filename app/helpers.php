<?php

if (!function_exists('price_without_vat')) {

    function price_without_vat(float $price_with_vat, int $vat_rate = 20): float 
    {
        return round($price_with_vat / (1.0 + (float)env('VAT_RATE', $vat_rate)), 2);
    }
}
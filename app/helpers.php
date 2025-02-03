<?php

if (!function_exists('price_without_vat')) {
	function price_without_vat(float $price_with_vat, float $vat_rate = .2): float {
		return round($price_with_vat / (1 + (float) env('VAT_RATE', $vat_rate)), 2);
	}
}

// Translation Lower case first
if (!function_exists('transL')) {
	function transL($key, $replace = [], $locale = null) {


		$key = trans($key, $replace, $locale);
		// return mb_strtolower($key, 'UTF-8');
		return mb_substr(mb_strtolower($key, 'UTF-8'), 0, 1) . mb_substr($key, 1);
	}
}
if (!function_exists('__L')) {
	function __L($key, $replace = [], $locale = null) {
		return transL($key, $replace, $locale);
	}
}

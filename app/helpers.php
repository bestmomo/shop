<?php

use App\Http\Tools\TimeFcts;

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

if (!function_exists('bigN')) {
	/**
	 * Formatte un nombre en fonction de la locale.
	 *
	 * Retourne une chaine de caractères correspondant au nombre $r formaté en fonction de la locale $locale.
	 * Si $locale n'est pas fournie, la locale de l'application est utilisée.
	 * Usage si besoin de préciser le nombre n de décimales : bigN(round(r, n))
	 *
	 * @param float|int $r        Le nombre à formatter.
	 * @param null|string $locale La locale à utiliser. Si null, la locale de l'application est utilisée.
	 * @return string             La chaine de caractères correspondant au nombre formaté.
	 */
	function bigN(float|int $r, $locale = null): bool|string {
		$locale ??= (new TimeFcts())->appLocale();
		$fmt = new NumberFormatter(locale: $locale, style: NumberFormatter::DECIMAL);

		echo $locale . '<hr>';

		return $fmt->format(num: $r);
	}
}

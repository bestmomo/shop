<?php

use LaravelLang\LocaleList\Locale;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Barryvdh\Debugbar\Facades\Debugbar;

if (!function_exists('price_without_vat')) {
	function price_without_vat(float $price_with_vat, float $vat_rate = .2): float {
		
		return round($price_with_vat / (1 + (float) env('VAT_RATE', $vat_rate)), 2);
	}
}

// Translation Lower case first
if (!function_exists('transL')) {
	function transL($key, $replace = [], $locale = null) {
		$key = trans($key, $replace, $locale);

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
	 * @param mixed $dec
	 * @return string             La chaine de caractères correspondant au nombre formaté.
	 */
	function bigN(float|int $r, $dec = 2, $locale = null): bool|string {
		$locale ??= substr(Config::get('app.locale'), 0, 2);;
		$fmt = new NumberFormatter(locale: $locale, style: NumberFormatter::DECIMAL);

		// echo $locale . '<hr>';

		return $fmt->format(num: round($r, $dec));
	}
}

if (!function_exists('ftC')) {
	/**
	 * Formatte un montant en fonction de la locale de l'application.
	 *
	 * Retourne une chaine de caractères correspondant au montant $amount formaté en fonction de la locale de l'application.
	 * La locale est définie par la constante APP_LOCALE dans le fichier .env.
	 * Si le montant est nul ou vide, une chaine vide est retournée.
	 *
	 * @param float|int $amount Le montant à formatter.
	 * @param null|mixed $locale
	 * @return string           La chaine de caractères correspondant au montant formaté.
	 */
	function ftC($amount, $locale = null): bool|string {
		// $locale     = 'fr_EUR';
		// $locale = 'en_JPY';
		// $locale = 'en_RMB';
		// $locale = 'en_CNY';
		// $locale = 'de_EUR';
		// $locale = 'de_EUR';
		// $locale     = 'en_GBP';
		// $locale     = 'en_USD';
		// $locale     = 'fr_CAND';
		// $locale     = 'cn_CNY';

		$locale ??= config('app.locale');

		$lang = substr($locale, 0, 2);
		preg_match('/_([^_]*)$/', $locale, $matches);
		$currency  = $matches[1] ?? 'EUR';
		$formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
		$formatted = $formatter->formatCurrency($amount, $currency);
		// $formatted = $formatter->formatCurrency($amount, match ($matches[1]) {
		// 	'en'    => 'GBP',
		// 	'us'    => 'USD',
		// 	default => 'EUR'
		// });
		Debugbar::info($locale);
		Debugbar::info($lang);
		Debugbar::info(message: $currency);
		Debugbar::info($formatted);

		return $formatted;
	}
}

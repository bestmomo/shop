<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\{App, Config};
use LaravelLang\LocaleList\Locale;

if (!function_exists('price_without_vat')) {
	function price_without_vat(float $price_with_vat, float $vat_rate = .2): float
	{
		return round($price_with_vat / (1 + (float) env('VAT_RATE', $vat_rate)), 2);
	}
}

// Translation Lower case first
if (!function_exists('transL')) {
	function transL($key, $replace = [], $locale = null)
	{
		$key = trans($key, $replace, $locale);

		return mb_substr(mb_strtolower($key, 'UTF-8'), 0, 1) . mb_substr($key, 1);
	}
}
if (!function_exists('__L')) {
	function __L($key, $replace = [], $locale = null)
	{
		return transL($key, $replace, $locale);
	}
}

if (!function_exists(function: 'bigR')) {
	/**
	 * Formatte un grand nombre Réel (BIG_Real) en fonction de la locale.
	 *
     * Ex. :
     * - fr    : 12 345,00 €
     * - de_EUR: $12,345.00
     * - en_USD: $12,345.00
     *
	 * Retourne une chaine de caractères correspondant au nombre $r formaté en fonction de la locale $locale.
	 * Si $locale n'est pas fournie, la locale de l'application est utilisée.
	 * Usage si besoin de préciser le nombre n de décimales : bigR(round(r, n))
	 *
	 * @param float|int   $r      le nombre à formatter
	 * @param null|string $locale La locale à utiliser. Si null, la locale de l'application est utilisée.
	 *
	 * @return string la chaine de caractères correspondant au nombre formaté
	 */
	function bigR(float|int $r, $dec = 2, $locale = null): bool|string
	{
		$locale ??= substr(Config::get('app.locale'), 0, 2);
		$fmt = new NumberFormatter(locale: $locale, style: NumberFormatter::DECIMAL);

		// echo "$locale<hr>";

		return $fmt->format(num: round($r, $dec));
	}
}

if (!function_exists('ftA')) {
	/**
	 * Formatte un montant (FormaT_Amount) en fonction de la locale de l'application.
	 *
	 * Retourne une chaine de caractères correspondant au montant $amount formaté en fonction de la locale de l'application.
	 * La locale est définie par la constante APP_LOCALE dans le fichier .env.
	 * Si le montant est nul ou vide, une chaine vide est retournée.
	 * Ex.: 123456 → 12 456,00 € pour .env/APP_LOCALE=fr
	 * Ex.: 123456 → $12,456.00 pour .env/APP_LOCALE=en_USD
	 *
	 * ⚠️ L'extension 'Intl' doit être activée (Cas par défaut dans les dernières versions de PHP).
	 *
	 * @param float|int   $amount le montant à formatter
	 * @param null|string $locale
	 *	 * @return string la chaine de caractères correspondant au montant formaté
	 */
	function ftA($amount, $locale = null): bool|string
	{
		// Décommenter 1 seule à la fois pour forcer la conf et voir l'affichage du prix (Listing)
		// $locale = 'en_JPY'; // ¥12,345.68
		// $locale = 'de_EUR'; // 12.345,68 €
		// $locale = 'en_GBP'; // £12,345.68
		// $locale = 'en_USD'; // $12,345.68

		$locale ??= config('app.locale');

		$lang = substr($locale, 0, 2);
		preg_match('/_([^_]*)$/', $locale, $matches);
		$currency  = $matches[1] ?? 'EUR';
		$formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
		$formatted = $formatter->formatCurrency((float) $amount, $currency);

        // Debugbar::addMessage($formatted, 'Helpers ftA');

		// À oublier pour l'heure: $formatted = $formatter->formatCurrency($amount, match ($matches[1]) {
		// 	'en'    => 'GBP',
		// 	'us'    => 'USD',
		// 	default => 'EUR'
		// });
		// Debugbar::info($formatted);

		return $formatted;
	}

	// if (!function_exists('getBestPrice_ori')) {
	// 	/**
	// 	 * Calcule le meilleur prix pour un produit en tenant compte des promotions.
	// 	 *
	// 	 * @param \App\Models\Product $product
	// 	 * @return float
	// 	 */
	// 	function getBestPrice_ori($product)
	// 	{
	// 		$promoGlobal = \App\Models\Setting::where('key', 'promotion')->first();

	// 		// Vérifie si la promotion globale est valide
	// 		$globalPromoValid = $promoGlobal && $promoGlobal->value && now()->between($promoGlobal->date1, $promoGlobal->date2);

	// 		// Vérifie si la promotion spécifique du produit est valide
	// 		$productPromoValid = $product->promotion_price && now()->between($product->promotion_start_date, $product->promotion_end_date);

	// 		// Initialise le meilleur prix avec le prix normal du produit
	// 		$bestPrice = $product->price;

	// 		// Si la promotion spécifique du produit est valide, utilise ce prix
	// 		if ($productPromoValid) {
	// 			$bestPrice = $product->promotion_price;
	// 		}

	// 		// Si la promotion globale est valide, calcule le prix avec la réduction globale
	// 		if ($globalPromoValid) {
	// 			$globalPromoPrice = $product->price * (1 - $promoGlobal->value / 100);
	// 			if ($globalPromoPrice < $bestPrice) {
	// 				$bestPrice = $globalPromoPrice;
	// 			}
	// 		}

	// 		return $bestPrice;
	// 	}
	// }
}
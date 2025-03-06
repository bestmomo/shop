<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

namespace App\Services;

use App\Models\Setting;

class Marketing
{
	public $promotion;

	public function globalPromotion()
	{
		$globalPromo = Setting::where('key', 'promotion')->firstOrCreate(['key' => 'promotion']);

		if ($this->isValidPromotion($globalPromo)) {
			$this->setPromotionStatus($globalPromo);
		} else {
			$globalPromo->active = false;
		}

		return $globalPromo;
	}

	public function bestPrice($product = null)
	{
		$promoGlobal = $this->globalPromotion();

		$normal = $product->price;
		if($product->promotion_price) {
			$promo  = (now()->isSameDay($product->promotion_start_date) || now()->isSameDay($product->promotion_end_date) || $product->promotion_start_date <= now() && now() <= $product->promotion_end_date) ? $product->promotion_price : null;
		} else {
			$promo = null;
		}

		// Calculer le prix avec la promotion globale uniquement si elle est active
		$globalPromoPrice = $promoGlobal->active ? ($product->price * (1 - $promoGlobal->value / 100)) : null;

		$bestPrice = $this->determineBestPrice($normal, $promo, $globalPromoPrice, $product, $promoGlobal);

		$bestPrice->normal = $product->price;

		return $bestPrice;
	}

	private function isValidPromotion($promo)
	{
		return $promo->value && $promo->date1 && $promo->date2;
	}

	private function setPromotionStatus($promo)
	{
		if (now()->isBefore($promo->date1)) {
			$promo->text   = transL('Coming soon');
			$promo->active = false;
		} elseif (now()->isSameDay($promo->date1) || now()->between($promo->date1, $promo->date2) || now()->isSameDay($promo->date2)) {
			$promo->active = true;
			$promo->text   = trans('in progress');
		} else {
			$promo->text   = transL('Expired_feminine');
			$promo->active = false;
		}
	}

	private function determineBestPrice($normal, $promo, $globalPromoPrice, $product, $promoGlobal)
	{
		$bestPrice = new \stdClass();

		// Filtrer les valeurs nulles ou zéro
		$validPrices = array_filter([$normal, $promo, $globalPromoPrice], function ($value) {
			return null !== $value && $value > 0;
		});

		if (empty($validPrices)) {
			$bestPrice->amount     = $normal;
			$bestPrice->origin     = 'normal';
			$bestPrice->origin_end = null;
		} else {
			$bestPrice->amount     = min($validPrices);
			$bestPrice->origin     = $this->getPriceOrigin($bestPrice->amount, $normal, $promo);
			$bestPrice->origin_end = $this->getOriginEndDate($bestPrice->origin, $product, $promoGlobal);
		}

		return $bestPrice;
	}

	private function getPriceOrigin($amount, $normal, $promo)
	{
		if ($amount == $normal) {
			return 'normal';
		}
		if ($amount == $promo) {
			return 'promo';
		}

		return 'global';
	}

	private function getOriginEndDate($origin, $product, $promoGlobal)
	{
		if ('promo' === $origin) {
			return $product?->promotion_end_date;
		}
		if ('global' === $origin) {
			return $promoGlobal?->date2;
		}

		return null;
	}
}

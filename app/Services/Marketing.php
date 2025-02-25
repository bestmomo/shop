<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

namespace App\Services;

use App\Models\Setting;
use Barryvdh\Debugbar\Facades\Debugbar;

class Marketing
{
	public $promotion;

	public function globalPromotion()
	{
		$globalPromo = Setting::where('key', 'promotion')->firstOrCreate(['key' => 'promotion']);

		if ($globalPromo->value) {
			$now = now();
			if ($now->isBefore($globalPromo->date1)) {
				$globalPromo->text = transL('Coming soon');
			} elseif ($now->between($globalPromo->date1, $globalPromo->date2)) {
				$globalPromo->active = true;
				$globalPromo->text   = trans('in progress');
			} else {
				$globalPromo->text = transL('Expired_feminine');
			}
		}

		return $globalPromo;
	}

	public function bestPrice($product = null)
	{
		$promoGlobal = $this->globalPromotion();

		$normal = $product->price;

		$promo = $product->promotion_price;

		$globalPromo = $product->price * (1 - $promoGlobal->value / 100);

		$bestPrice = new \stdClass();

		// Debugbar::info($normal, $promo, $globalPromo);
		// $productPromoValid = $product->promotion_price && $promoGlobal->active;

		$bestPrice->amount = min(array_filter([$normal, $promo, $globalPromo], function ($value) {
			return null !== $value && 0 !== $value;
		}));

		$vars = array_filter([$normal, $promo, $globalPromo], function ($value) {
			return null !== $value && 0 !== $value;
		});

		if (count($vars) > 0) {
			$min_value  = min($vars);
			$winner_key = array_search($min_value, [$normal, $promo, $globalPromo]);
			switch ($winner_key) {
				case 0:
					$bestPriceOrigin = 'normal';

					break;
				case 1:
					$bestPriceOrigin    = 'promo';
					$bestPriceOriginEnd = $product?->promotion_end_date;

					break;
				case 2:
					$bestPriceOrigin    = 'global';
					$bestPriceOriginEnd = $promoGlobal?->date2;

					break;
			}
		} else {
			$bestPriceOrigin = null;
		}
		$bestPrice->origin = $bestPriceOrigin;
		$bestPrice->origin_end = $bestPriceOriginEnd;
		$bestPrice->normal = $product->price;

		return $bestPrice;
	}
}
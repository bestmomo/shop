<?php

namespace App\Services;

use App\Models\Setting;

class Marketing
{
    public $promotion;

    public function globalPromotion()
    {
        $globalPromo = Setting::where('key', 'promotion')->firstOrCreate(['key' => 'promotion']);

        if ($this->isValidPromotion($globalPromo)) {
            $now = now();
            $this->setPromotionStatus($globalPromo, $now);
        } else {
            $globalPromo->active = false;
        }

        return $globalPromo;
    }

    private function isValidPromotion($promo)
    {
        return $promo->value && $promo->date1 && $promo->date2;
    }

    private function setPromotionStatus($promo, $now)
    {
        if ($now->isBefore($promo->date1)) {
            $promo->text = transL('Coming soon');
            $promo->active = false;
        } elseif ($now->between($promo->date1, $promo->date2)) {
            $promo->active = true;
            $promo->text = trans('in progress');
        } else {
            $promo->text = transL('Expired_feminine');
            $promo->active = false;
        }
    }

    public function bestPrice($product = null)
    {
        $promoGlobal = $this->globalPromotion();

        $normal = $product->price;
        $promo = ($product->promotion_start_date <= now() && now() <= $product->promotion_end_date) ? $product->promotion_price:null;

        // Calculer le prix avec la promotion globale uniquement si elle est active
        $globalPromoPrice = $promoGlobal->active ? ($product->price * (1 - $promoGlobal->value / 100)) : null;

        $bestPrice = $this->determineBestPrice($normal, $promo, $globalPromoPrice, $product, $promoGlobal);

        $bestPrice->normal = $product->price;

        return $bestPrice;
    }

    private function determineBestPrice($normal, $promo, $globalPromoPrice, $product, $promoGlobal)
    {
        $bestPrice = new \stdClass();

        // Filtrer les valeurs nulles ou zéro
        $validPrices = array_filter([$normal, $promo, $globalPromoPrice], function ($value) {
            return $value !== null && $value > 0;
        });

        if (empty($validPrices)) {
            $bestPrice->amount = $normal;
            $bestPrice->origin = 'normal';
            $bestPrice->origin_end = null;
        } else {
            $bestPrice->amount = min($validPrices);
            $bestPrice->origin = $this->getPriceOrigin($bestPrice->amount, $normal, $promo);
            $bestPrice->origin_end = $this->getOriginEndDate($bestPrice->origin, $product, $promoGlobal);
        }

        return $bestPrice;
    }

    private function getPriceOrigin($amount, $normal, $promo)
    {
        if ($amount == $normal) {
            return 'normal';
        } elseif ($amount == $promo) {
            return 'promo';
        } else {
            return 'global';
        }
    }

    private function getOriginEndDate($origin, $product, $promoGlobal)
    {
        if ($origin === 'promo') {
            return $product?->promotion_end_date;
        } elseif ($origin === 'global') {
            return $promoGlobal?->date2;
        }
        return null;
    }
}

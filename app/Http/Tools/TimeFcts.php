<?php

/**
 * (ɔ) Mon CMS - 2024-2025
 */

namespace App\Http\Tools;

use Carbon\Carbon;

use Illuminate\Support\Facades\Config;

class TimeFcts {
	/**
	 * Return the locale for a given language code
	 *
	 * @return string The locale, ex.: fr → fr_FR
	 */
	public function appLocale(): bool|string {
		$languageCode = Config::get('app.locale');

		return \Locale::composeLocale(['language' => $languageCode, 'region' => strtoupper($languageCode)]);
	}

	public function getCurrentDate() {
		Carbon::setLocale(app()->getLocale());
		$dateJ = Carbon::now()->isoFormat('dddd D MMMM YYYY');
		$dateH = Carbon::now()->isoFormat('H\\Hmm');
		$dateH = str_replace(' ', '&nbsp;', $dateH);

		return $dateJ . ' ' . __('à') . '&nbsp;' . $dateH;
	}
}

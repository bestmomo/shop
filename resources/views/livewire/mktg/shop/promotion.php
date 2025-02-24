<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

use App\Models\Setting;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Volt\Component;

new class extends Component {
	public $promotion;
	public $target;

	public function mount($target = 'front')
	{
		$this->target = $target;

		$promotion = Setting::where('key', 'promotion')->firstOrCreate(['key' => 'promotion']);
		Debugbar::info('promotion', $this->promotion);

		if ($promotion->value) {
			$now = now();
			if ($now->isBefore($promotion->date1)) {
				$promotion->text = transL('Coming soon');
			} elseif ($now->between($promotion->date1, $promotion->date2)) {
				$promotion->text = trans('in progress');
			} else {
				$promotion->text = transL('Expired_feminine');
			}
		}

        $this->promotion = $promotion;
	}

	public function with()
	{
		return [
			'promotion' => $this->promotion,
		];
	}
};

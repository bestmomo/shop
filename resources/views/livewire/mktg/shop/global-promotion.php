<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

use Livewire\Volt\Component;

new class extends Component {
	public $promotion;

	public function mount($promotion, $target = 'front')
	{
		$this->promotion = $promotion;
		$this->target    = $target;
	}

	public function with()
	{
		return [
			'target' => $this->target,
		];
	}
};
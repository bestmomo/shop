<?php

/**
 * (ɔ) Mon CMS - 2024-2025
 */

namespace App\Http\Tools;

use Barryvdh\Debugbar\Facades\Debugbar;

class Memos {
	public function debugbarTips():void {
		Debugbar::debug('debug');
		Debugbar::info('info');
		Debugbar::notice('notice');
		Debugbar::warning('warning');
		Debugbar::error('error');
		Debugbar::critical('critical');
		Debugbar::alert('alert');
		Debugbar::emergency('emergency');

		Debugbar::addMessage('addMessage', 'Exemple addMessage');
	}
}

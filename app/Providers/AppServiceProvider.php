<?php

namespace App\Providers;

use App\Models\Shop;
use App\Services\OrderService;
use Illuminate\Support\Facades\{Blade, View};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 */
	// public function register(): void {
	// 	//
	// }

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		if (app()->runningInConsole()) {
			return;
		}

		View::share('shop', Shop::firstOrFail());

		Blade::directive(name: 'langL', handler: function ($expression): string {
			return "<?= transL({$expression}); ?>";
});
}
}
?>

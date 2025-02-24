<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

namespace Database\Seeders;

use App\Models\ {Address, Colissimo, Country, Order, Page, Product, Range, Shop, State, User};
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		Country::insert([
			['name' => 'France', 'tax' => 0.2],
			['name' => 'Belgique', 'tax' => 0.2],
			['name' => 'Suisse', 'tax' => 0],
			['name' => 'Canada', 'tax' => 0],
		]);

		Range::insert([
			['max' => 1],
			['max' => 2],
			['max' => 3],
			['max' => 100],
		]);

		Colissimo::insert([
			['country_id' => 1, 'range_id' => 1, 'price' => 7.25],
			['country_id' => 1, 'range_id' => 2, 'price' => 8.95],
			['country_id' => 1, 'range_id' => 3, 'price' => 13.75],
			['country_id' => 1, 'range_id' => 4, 'price' => 0],
			['country_id' => 2, 'range_id' => 1, 'price' => 15.5],
			['country_id' => 2, 'range_id' => 2, 'price' => 17.55],
			['country_id' => 2, 'range_id' => 3, 'price' => 22.45],
			['country_id' => 2, 'range_id' => 4, 'price' => 0],
			['country_id' => 3, 'range_id' => 1, 'price' => 15.5],
			['country_id' => 3, 'range_id' => 2, 'price' => 17.55],
			['country_id' => 3, 'range_id' => 3, 'price' => 22.45],
			['country_id' => 3, 'range_id' => 4, 'price' => 0],
			['country_id' => 4, 'range_id' => 1, 'price' => 27.65],
			['country_id' => 4, 'range_id' => 2, 'price' => 38],
			['country_id' => 4, 'range_id' => 3, 'price' => 55.65],
			['country_id' => 4, 'range_id' => 4, 'price' => 0],
		]);

		State::insert([
			['name' => 'Attente chèque', 'slug' => 'cheque', 'color' => 'blue', 'indice' => 1],
			['name' => 'Attente mandat administratif', 'slug' => 'mandat', 'color' => 'blue', 'indice' => 1],
			['name' => 'Attente virement', 'slug' => 'virement', 'color' => 'blue', 'indice' => 1],
			['name' => 'Attente paiement par carte', 'slug' => 'carte', 'color' => 'blue', 'indice' => 1],
			['name' => 'Erreur de paiement', 'slug' => 'erreur', 'color' => 'red', 'indice' => 0],
			['name' => 'Annulé', 'slug' => 'annule', 'color' => 'red', 'indice' => 2],
			['name' => 'Mandat administratif reçu', 'slug' => 'mandat_ok', 'color' => 'green', 'indice' => 3],
			['name' => 'Paiement accepté', 'slug' => 'paiement_ok', 'color' => 'green', 'indice' => 4], ['name' => 'Envoi différé', 'slug' => 'envoi-differe', 'color' => 'green', 'indice' => 4],
			['name' => 'Expédié', 'slug' => 'expedie', 'color' => 'gray', 'indice' => 5],
			['name' => 'Remis en main propre', 'slug' => 'remis', 'color' => 'gray', 'indice' => 5],
			['name' => 'Livré', 'slug' => 'livre', 'color' => 'gray', 'indice' => 5],
			['name' => 'Remboursé', 'slug' => 'rembourse', 'color' => 'red', 'indice' => 6],
		]);

		User::factory()
			->count(20)
			->create()
			->each(function ($user) {
				$user->addresses()->createMany(
					Address::factory()->count(mt_rand(2, 3))->make()->toArray()
				);
			});

		$user        = User::find(1);
		$user->admin = true;
		$user->save();

		$adminUser             = new User();
		$adminUser->name       = env('ADMIN_FIRSTNAME', 'Administrateur');
		$adminUser->firstname  = env('ADMIN_NAME', 'PRINCIPAL');
		$adminUser->newsletter = true;
		$adminUser->admin      = true;
		$adminUser->email      = env('ADMIN_EMAIL', 'admin@example.com');
		$adminUser->password   = Hash::make(env('ADMIN_PASSWORD', 'password'));
		$adminUser->save();

		foreach ([
			['name' => 'Montre', 'price' => 56, 'weight' => 0.3, 'active' => true, 'quantity' => 100, 'quantity_alert' => 10, 'image' => 'montre.png', 'description' => 'Superbe montre de luxe automatique.'],
			['name' => 'Lunettes', 'price' => 75, 'weight' => 0.3, 'active' => true, 'quantity' => 100, 'quantity_alert' => 10, 'image' => 'lunettes.png', 'description' => 'Superbe paire de lunettes de soleil.', 'promotion_price' => 69.9, 'promotion_start_date' => now(), 'promotion_end_date' => fake()->dateTimeBetween(now(), '+1 month')],
			['name' => 'Noix', 'price' => 26, 'weight' => 1, 'active' => true, 'quantity' => 100, 'quantity_alert' => 10, 'image' => 'noix.png', 'description' => 'Merveilleuses noix biologiques.'],
			['name' => 'Pain', 'price' => 12, 'weight' => .5, 'active' => true, 'quantity' => 100, 'quantity_alert' => 10, 'image' => 'pain.png', 'description' => 'Délicieux pain biologique.'],
			['name' => 'Pc portable', 'price' => 450, 'weight' => 2, 'active' => true, 'quantity' => 100, 'quantity_alert' => 10, 'image' => 'pc.png', 'description' => 'Superbe pc portable.'],
			['name' => 'Rollers', 'price' => 1500, 'weight' => 2.6, 'active' => true, 'quantity' => 100, 'quantity_alert' => 10, 'image' => 'rollers.png', 'description' => 'Paire de rollers adaptés aux slaloms.'],
		] as $productData) {
			Product::create($productData);
		}

		Shop::factory()->create();

		$items = [
			['livraisons', 'Livraisons'],
			['mentions-legales', 'Mentions légales'],
			['conditions-generales-de-vente', 'Conditons générales de vente'],
			['politique-de-confidentialite', 'Politique de confidentialité'],
			['respect-environnement', 'Respect de l\'environnement'],
			['mandat-administratif', 'Mandat administratif'],
		];

		foreach ($items as $item) {
			Page::factory()->create([
				'slug'  => $item[0],
				'title' => $item[1],
			]);
		}

		Order::factory()
			->count(100)
			->create()
			->each(function ($order) {
				$address = $order->user->addresses()->take(1)->get()->makeHidden(['id', 'user_id'])->toArray();
				$order->addresses()->create($address[0]);
				if (mt_rand(0, 1)) {
					$address                   = $order->user->addresses()->skip(1)->take(1)->get()->makeHidden(['id', 'user_id'])->toArray();
					$address[0]['facturation'] = false;
					$order->addresses()->create($address[0]);
				}
				$countryId = $address[0]['country_id'];
				$total     = 0;
				$product   = Product::find(mt_rand(1, 3));
				$quantity  = mt_rand(1, 3);
				$price     = $product->price * $quantity;
				$total     = $price;
				$order->products()->create(
					[
						'name'              => $product->name,
						'total_price_gross' => $price,
						'quantity'          => $quantity,
					]
				);
				if (mt_rand(0, 1)) {
					$product  = Product::find(mt_rand(4, 6));
					$quantity = mt_rand(1, 3);
					$price    = $product->price * $quantity;
					$total += $price;
					$order->products()->create(
						[
							'name'              => $product->name,
							'total_price_gross' => $price,
							'quantity'          => $quantity,
						]
					);
				}
				if ('carte' === $order->payment && 8 === $order->state_id) {
					$order->payment_infos()->create(['payment_id' => (string) str()->uuid()]);
				}
				$order->tax   = $countryId > 2 ? 0 : .2;
				$order->total = $total;
				$order->save();
			});

		Setting::insert([
			['key' => 'promotion', 'value' => 20, 'date1' => now(), 'date2' => now()->addDays(7)],
		]);

		// REPORT
		printf('%s%s', str_repeat(' ', 2), "Data tables properly filled.\n\n");
	}
}

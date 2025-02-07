<?php

namespace App\Services;

use App\Http\Tools\Memos;
use App\Models\Order;
use App\Traits\ManageOrders;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Builder;

class OrderService {
	use ManageOrders;

	private object $req;

	public function __construct($params) {
		$this->sortBy = $params->sortBy;
        $this->search   = $params->search;
		// (new Memos())->debugBarTips();

		Debugbar::addMessage($this, 'Service');
		Debugbar::addMessage($this->req()->toSql(), 'Req');
	}

	public function hello() {
		// Debugbar::info('Req',  $req);
		// Debugbar::message( $req, 'Req');

		return 'Hello';
	}

	public function req () {
		$usedDbSystem = config('database.default', 'mysql');
		$adaptedReq   = 'sqlite' === $usedDbSystem ? "users.name || ' ' || users.firstname" : "CONCAT(users.name, ' ', users.firstname)";

        $sortBy = $this->sortBy;
        $search = $this->search;

		return Order::with('user', 'state', 'addresses')
			->when(
				'user' === $this->sortBy['column'],
				function ($query) use ($adaptedReq) {
					$query->orderBy(function ($query) use ($adaptedReq) {
						$query
							->selectRaw(
								'COALESCE(
                                        (SELECT company FROM order_addresses WHERE order_addresses.order_id = orders.id LIMIT 1),
                                        (SELECT ' .
								$adaptedReq .
								' FROM users
                                        WHERE users.id = orders.user_id)
                                    )',
							)
							->limit(1);
					}, $this->sortBy['direction']);
				},
				function ($query) {
					$query->orderBy(...array_values($this->sortBy));
				},
			)
			->when($this->search, function (Builder $q) {
				$q->where('reference', 'like', "%{$this->search}%")
					->orWhereRelation('addresses', 'company', 'like', "%{$this->search}%")
					->orWhereRelation('user', 'name', 'like', "%{$this->search}%")
					->orWhereRelation('user', 'firstname', 'like', "%{$this->search}%")
					->orWhere('total', 'like', "%{$this->search}%")
					->orWhere('invoice_id', 'like', "%{$this->search}%");
			});
            
	}

	public function getOrders($selection) {
		$this->selection = $selection;
		$usedDbSystem    = config('database.default', 'mysql');
		$adaptedReq      = 'sqlite' === $usedDbSystem ? "users.name || ' ' || users.firstname" : "CONCAT(users.name, ' ', users.firstname)";
		// Debugbar::addMessage($adaptedReq);
		$orders = [
			'orders' => Order::with('user', 'state', 'addresses')
				->when(
					'user' === $this->selection->sortBy['column'],
					function ($query) use ($adaptedReq) {
						$query->orderBy(function ($query) use ($adaptedReq) {
							$query
								->selectRaw(
									'COALESCE(
                                        (SELECT company FROM order_addresses WHERE order_addresses.order_id = orders.id LIMIT 1),
                                        (SELECT ' . $adaptedReq . ' FROM users
                                        WHERE users.id = orders.user_id)
                                    )',
								)
								->limit(1);
						}, direction: $this->selection->sortBy['direction']);
					},
					function ($query) {
						$query->orderBy(...array_values($this->selection->sortBy));
					},
				)
				->when($this->selection->search, function (Builder $q) {
					$q->where('reference', 'like', "%{$this->search}%")
						->orWhereRelation('addresses', 'company', 'like', "%{$this->search}%")
						->orWhereRelation('user', 'name', 'like', "%{$this->search}%")
						->orWhereRelation('user', 'firstname', 'like', "%{$this->search}%")
						->orWhere('total', 'like', "%{$this->search}%")
						->orWhere('invoice_id', 'like', "%{$this->search}%");
				})
				->paginate($this->selection->perPage),
		];
		// Debugbar::info($orders['orders']->first());
		// Debugbar::info($orders['orders']->first()->user);
		$newCollection = $this->setPrettyOrdersIndexes($orders['orders']->getCollection());
		$orders['orders']->setCollection($newCollection);

		return $orders;
	}
}

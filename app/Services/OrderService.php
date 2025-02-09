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
	private $adaptedReq;

	public function __construct($params) {
		$this->sortBy = $params->sortBy;
		$this->search = $params->search;
		// Debugbar::addMessage($this->req()->toSql(), 'Req OrderService');
		// (new Memos())->debugBarTips();
	}

	public function req () {
		$this->adaptedReq = 'sqlite' === config('database.default', 'mysql') ? "users.name || ' ' || users.firstname" : "CONCAT(users.name, ' ', users.firstname)";

		return Order::with('user', 'state', 'addresses')
			->when(
				'user' === $this->sortBy['column'],
				function ($query) {
					$query->orderBy(function ($query) {
						$query
							->selectRaw(
								'COALESCE(
                                        (SELECT company FROM order_addresses WHERE order_addresses.order_id = orders.id LIMIT 1),
                                        (SELECT ' .
								$this->adaptedReq .
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

}

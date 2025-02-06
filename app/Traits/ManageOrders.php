<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

// require_once __DIR__.'/ManageOrderIndexes.php';

trait ManageOrders {
	use ManageOrderIndexes;

	public array $sortBy = [
		'column'    => 'invoice_id', //2ar  'created_at'
		'direction' => 'desc',
	];

	public function headersOrders(): array {
		return [
			['key' => 'id', 'label' => __('#')],
			['key' => 'reference', 'label' => __('Reference')],
			['key' => 'user', 'label' => __('Customer')],
			['key' => 'total', 'label' => __('Total price')],
			['key' => 'created_at', 'label' => __('Date')],
			['key' => 'state', 'label' => __('Etat'), 'sortable' => false],
			['key' => 'invoice_id', 'label' => __('Invoice')],
		];
	}

	public function setPrettyOrdersIndexes($orders = null): Collection {
		// echo get_class($orders);

		$orders->transform(function ($order) {
			[$order->orderId, $order->invoiceId] = $this->getIndexes(order: $order);

			return $order;
		});
		// dump($this);
		// dump($this->getOrderId($orders->first()));
		// $o1                                 = $orders->first();
		// list($o1->orderId,$o1->invoiceId  ) = $this->getIndexes($o1);

		return $orders;
	}
}

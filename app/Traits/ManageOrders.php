<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ManageOrders {
	use ManageOrder;

	public array $sortBy = [
		'column'    => 'id', //Original sort 'created_at' + direction
		'direction' => 'desc', // 'desc'
	];
	public string $search = '';

	public function headersOrders(): array {
		return [
			['key'   => 'id', 'label' => __('#'),
				'class' => 'text-center'],
			['key' => 'reference', 'label' => __('Reference')],
			['key' => 'user', 'label' => __('Customer')],
			['key' => 'total', 'label' => __('Total price')],
			['key' => 'created_at', 'label' => __('Date')],
			['key' => 'state', 'label' => __(key: 'State'), 'sortable' => false],
			['key' => 'invoice_id', 'label' => __('Invoice'), 'class' => 'text-center'],
		];
	}

	public function setPrettyOrdersIndexes(Collection $orders = null): Collection {
		$orders->transform(function ($order) {
			list($order->orderId, $order->invoiceId) = $this->getIndexes(order: $order);

			return $order;
		});

		return $orders;
	}
}

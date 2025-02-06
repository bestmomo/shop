<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ManageOrders {
	use ManageOrderIndexes;

	public array $sortBy = [
		'column'    => 'invoice_id', //2ar  'created_at'
		'direction' => 'desc',
	];

	public function headersOrders(): array {
		return [
			['key' => 'id', 'label' => __('#'), 'class' => 'text-center'],
			['key' => 'reference', 'label' => __('Reference')],
			['key' => 'user', 'label' => __('Customer')],
			['key' => 'total', 'label' => __('Total price')],
			['key' => 'created_at', 'label' => __('Date')],
			['key' => 'state', 'label' => __(key: 'State'), 'sortable' => false],
			['key' => 'invoice_id', 'label' => __('Invoice')],
		];
	}

	public function setPrettyOrdersIndexes($orders = null): Collection {
		// echo get_class($orders);

		$orders->transform(function ($order) {
			[$order->orderId, $order->invoiceId] = $this->getIndexes(order: $order);

			return $order;
		});

        return $orders;
	}
}

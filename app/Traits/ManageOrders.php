<?php

namespace App\Traits;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Collection;

trait ManageOrders {
	use ManageOrderIndexes;

	public array $sortBy = [
		'column'    => 'invoice_id', //2ar  'created_at'
		'direction' => 'desc',
	];

	public function headersOrders(): array {
        Debugbar::info($this);
		return [
			['key' => 'id', 'label' => __('#'), 'class' => 'font-bold text-center'],
			['key' => 'reference', 'label' => __('Reference')],
			['key' => 'user', 'label' => __('Customer'), 'sortable' => false],
			['key' => 'total', 'label' => __('Total price')],
			['key' => 'created_at', 'label' => __('Date')],
			['key' => 'state', 'label' => __(key: 'State'), 'sortable' => false],
			['key' => 'invoice_id', 'label' => __('Invoice'), 'class' => 'text-center'],
		];
	}

	public function setPrettyOrdersIndexes(Collection $orders = null): Collection {
		// echo get_class($orders);

		$orders->transform(function ($order) {
			[$order->orderId, $order->invoiceId] = $this->getIndexes(order: $order);

			return $order;
		});

        return $orders;
	}
}

<?php

namespace App\Traits;

use App\Models\Order;

trait ManageOrderIndexes {
	/**
	 * Formats the given object by concatenating its creation date and invoice ID to generate a real like invoice's number.
	 *
	 * @param object $o An object containing 'created_at' and 'invoice_id' properties.
	 * @param null|string $locale Optional locale for formatting (unused in current implementation).
	 * @return string The formatted string with date and invoice ID separated by a non-breaking space.
	 */
	public function getIndexes(Order $order): array {
		$prettyDate   = $this->ftD($order->created_at);
		$idIndex      = $this->ftN($order->id);
		$invoiceIndex = $this->ftD($order->created_at) . ' ' . $this->ftN($order->invoice_id);

		return [$idIndex, $invoiceIndex];
		// return  $this->ftD(d: $this->created_at) . ' ' . $this->ftF(f: $this->invoice_id);
	}

	/**
	 * Format a Date string $d in 'Y-m-d H:i:s' format into a 'dd&nbsp;mm&nbsp;yy' string.
	 *
	 * @param string $d A date string in 'Y-m-d H:i:s' format.
	 * @return string The formatted string with day, month, and year on 2 digits separated by a non-breaking space.
	 */
	public function ftD(string $d): string {
		return
		substr(string: $d, offset: 8, length: 2) . ' ' .
		substr(string: $d, offset: 5, length: 2) . ' ' .
		substr(string: $d, offset: 2, length: 2);
	}

	/**
	 * Formats an int $n into a string padding with leading zeros to a width of 7 characters (6 digits + 1 space).
	 *
	 * @param  int $n The integer number to format.
	 * @return string The formatted string with the given number of decimal places, padded with leading zeros to a width of 7.
	 */
	public function ftN($n): string {
		$str                = (string) $n;
		$formattedWholePart = sprintf('%06d', $n);

		return substr($formattedWholePart, 0, 3) . ' ' . substr($formattedWholePart, 3);
	}
}

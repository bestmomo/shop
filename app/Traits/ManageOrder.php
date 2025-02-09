<?php

namespace App\Traits;

use App\Models\Order;

trait ManageOrder {
	/**
	 * Formate la date et l'ID de la commande ou de la facture pour générer un numéro de commande ressemblant à un numéro de commande réel de commande ou facture.
	 *
	 * @param object $o Un objet Order contenant entre autres, les propriétés 'name' (User), 'id' (Order), 'created_at' et 'invoice_id'.
	 * @return string   La chaîne formatée avec la date et l'ID de la commande ou de la facture.
	 */
	public function getIndexes(Order $order): array {
		$prettyDate   = $this->ftD($order->created_at);
		$idIndex      = strtoupper($order->user->name[0]) . ' ' . $this->ftN($order->id);
		$invoiceIndex = $this->ftD($order->created_at) . ' ' . $this->ftN($order->invoice_id);

		return [$idIndex, $invoiceIndex];
	}

	/**
	 * Formatte une chaîne de date $d au format 'Y-m-d H:i:s' en une chaîne 'dd[X]mm[X]yy'. (X = Séparateur optionnel)
	 *
	 * @param  string $d   Une chaîne de date au format 'Y-m-d H:i:s'.
	 * @param  string $sep Une chaîne pour le séparateur, rien par défaut.
	 * @return string      La chaîne formatée avec le jour, le mois et l'année sur 2 chiffres, séparés ou pas.
	 */
	public function ftD(string $d, $sep = ''): string {
		return
		substr(string: $d, offset: 2, length: 2) . $sep .
		substr(string: $d, offset: 5, length: 2) . $sep .
		substr(string: $d, offset: 8, length: 2);
	}

	/**
	 * Formate un entier $n en une chaîne en ajoutant des zéros en tête pour atteindre une largeur max. de 7 caractères (6 chiffres + 1 espace).
	 *
	 * @param  int         $n Le nombre entier à formater.
	 * @param  null|string $locale Locale optionnelle pour le formatage des grands nombres (Celle de la langue system par défaut).
	 * @return string      La chaîne formatée remplie de zéros complémentaires pour atteindre une longeur de 7 caractères.
	 */
	public function ftN(int|null $n): string {
		$str                = (string) $n;
		$formattedWholePart = sprintf('%06d', $n);

		return substr($formattedWholePart, 0, 3) . ' ' . substr($formattedWholePart, 3);
	}
	public function uuu() {
		return 'oki';
	}

}

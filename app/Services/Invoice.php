<?php

namespace App\Services;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class Invoice
{
    public function create(Order $order, $paid = false)
    {
        $order->load('addresses', 'products', 'addresses.country', 'user');

        // Adresse de facturation
        $addressOrder = $order->addresses->first();

        $text = $addressOrder->address;
        if($addressOrder->addressbis) {
            $text .= "\n" . $addressOrder->addressbis;
        }

        $invoice = [
            'kind' => 'vat',
            'test' => config('invoice.test') ? 'true' : 'false',
            'title' => $order->payment == 'mandat' ? 'Engagement juridique ' . $order->purchase_order :  'Commande référence ' . $order->reference,
            'buyer_street' => $text,
            'buyer_country' => $addressOrder->country->name,
            'buyer_post_code' => $addressOrder->postal,
            'buyer_city' => $addressOrder->city,
            'buyer_company' => $addressOrder->professionnal ? '1' : '0',
            'payment_type' => $order->payment_text,
            'payment_to' => now()->endOfMonth()->addMonth()->format('Y-m-d'),
            'status' => $paid ? 'Payé' : 'Créé',
        ];

        // Bon de commande éventuel
        if($order->payment === 'mandat') {
            $invoice['oid'] = $order->purchase_order;
        }

        // Si la facture a été payée
        if($paid) {
            $invoice['paid'] = $order->totalOrder;
        }

        // Si c'est un professionnel
        if($addressOrder->professionnal) {
            $invoice['buyer_name'] = "$addressOrder->company";
            if(isset($addressOrder->name)) {
                $invoice['buyer_first_name'] = $addressOrder->firstname;
                $invoice['buyer_last_name'] = $addressOrder->name;  
            } else {
                $invoice['buyer_first_name'] = $order->user->firstname;
                $invoice['buyer_last_name'] = $order->user->name;     
            }
        } else {
            $invoice['buyer_first_name'] = $addressOrder->firstname;
            $invoice['buyer_last_name'] = $addressOrder->name;
        }

        // Adresse et boîte postale
        $text = $addressOrder->address;
        if($addressOrder->addressbis) {
            $text .= " " . $addressOrder->addressbis;
        }
        if($addressOrder->bp) {
            $text .= " " . $addressOrder->bp;
        }
        $invoice['buyer_street'] = $text;

        // S'il y a une adresse de livraison
        if($order->addresses->count() === 2) {
            $invoice['use_delivery_address'] = true;
            $addressdelivery = $order->addresses->get(1);
            $text = '';
            if(isset($addressdelivery->name)) {
                $text .= "$addressdelivery->civility $addressdelivery->name $addressdelivery->firstname \n";
            }
            if($addressdelivery->company) {
                $text .= $addressdelivery->company . "\n";
            }
            $text .= $addressdelivery->address . "\n";
            if($addressdelivery->addressbis) {
                $text .= $addressdelivery->addressbis . "\n";
            }
            if($addressdelivery->bp) {
                $text .= 'BP ' . $addressdelivery->bp . "\n";
            }
            $text .= "$addressdelivery->postal $addressdelivery->city" . "\n";
            $text .= $addressdelivery->country->name . "\n";
            $invoice['delivery_address'] = $text;
        }
        
        // Taxe
        if($order->pick) {
            $tax = .2;
        } else {
            if(isset($addressdelivery)) {
                $tax = $addressdelivery->country->tax;
            } else {
                $tax = $addressOrder->country->tax;
            }
        }

        // Produits
        $positions = [];
        foreach($order->products as $product) {
            array_push($positions, [
                'name' => $product->name,
                'quantity' => $product->quantity,
                'tax' => $tax * 100,
                'total_price_gross' => $product->total_price_gross,
            ]);
        }

        // Frais d'expédition
        if($order->shipping > 0) {
          array_push($positions, [
              'name' => 'Frais d\'expédition',
              'quantity' => 1,
              'tax' => 0,
              'total_price_gross' => $order->shipping,
          ]);
        }

        $invoice['positions'] = $positions;

        // Envoi
        return Http::post(config('invoice.url') . 'invoices.json', [
            'api_token' => config('invoice.token'),
            'invoice' => $invoice,
        ]);

    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pick = fake()->boolean();
        $payment = ['carte', 'mandat', 'virement', 'cheque'][mt_rand(0, 3)];
        if($payment === 'carte') {
            $state_id = [4, 5, 6, 8, 9, 10][mt_rand(0, 5)];
        } else if($payment === 'mandat') {
            $state_id = [2, 6, 7, 8, 9, 10][mt_rand(0, 5)];
            if($state_id > 6) {
                $purchaseOrder = str()->random(6);
            }
        } else if($payment === 'virement') {
            $state_id = [3, 6, 8, 9, 10][mt_rand(0, 4)];
        } else if($payment === 'cheque') {
            $state_id = [1, 6, 8, 9, 10][mt_rand(0, 4)];
        }
        if($payment === 'carte' && in_array($state_id, [8, 9, 10])) {
            $invoice_id = $payment === 'carte' && in_array($state_id, [8, 9, 10]) ? fake()->numberBetween(10000, 90000) : null;
            $invoice_number = str()->random(6);
        } else {
            $invoice_id = null;
            $invoice_number = null;
        }
        
        return [
            'reference' => strtoupper(str()->random(8)),
            'shipping' => $pick ? 0 : mt_rand (500, 1500) / 100,
            'payment' => $payment,
            'state_id' => $state_id,
            'user_id' => mt_rand(1, 20),
            'purchase_order' => isset($purchaseOrder) ? $purchaseOrder : null,
            'pick' => $pick,
            'total' => 0,
            'tax' => [0, .2][mt_rand(0, 1)],
            'invoice_id' => $invoice_id,
            'invoice_number' => $invoice_number,
            'created_at' => fake()->dateTimeBetween('-2 years'),
        ];
    }
}

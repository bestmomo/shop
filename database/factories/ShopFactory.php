<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'address' => fake()->address,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
            'holder' => strtoupper(fake()->sentence(3)),
            'bic' => strtoupper(str()->random(8)),
            'iban' => fake()->iban,
            'bank' => fake()->sentence(2),
            'bank_address' => fake()->address,
            'facebook' => fake()->url,
            'home' => fake()->sentence(3),
            'home_infos' => fake()->text,
            'home_shipping' => fake()->text,
        ];
    }
}

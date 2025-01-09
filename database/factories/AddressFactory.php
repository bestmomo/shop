<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $professionnal = fake()->boolean();

        if(!$professionnal || ($professionnal && fake()->boolean())) {
            $name = fake()->lastName;
            $firstName = fake()->firstName;
        } else {
            $name = null;
            $firstName = null;
        }
        return [
            'professionnal' => $professionnal,
            'civility' => fake()->boolean() ? 'Mme': 'M.',
            'name' => $name,
            'firstname' => $firstName,
            'company' => $professionnal ? fake()->company : null,
            'address' => fake()->streetAddress,
            'addressbis' => fake()->boolean() ? fake()->secondaryAddress : null,
            'bp' => fake()->boolean() ? fake()->numberBetween(100, 900) : null,
            'postal' => fake()->numberBetween(10000, 90000),
            'city' => fake()->city,
            'country_id' => mt_rand(1, 4),
            'phone' => fake()->numberBetween(1000000000, 9000000000),
        ];
    }
}

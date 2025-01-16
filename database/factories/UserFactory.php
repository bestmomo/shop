<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->lastName,
            'firstname' => fake()->firstName,
            'email' => fake()->unique()->safeEmail,
            'password' => static::$password ??= Hash::make('password'),
            'newsletter' => fake()->boolean(),
            'created_at' => fake()->dateTimeBetween('-4 years', '-6 months'),
            'remember_token' => Str::random(10),
        ];
    }
}

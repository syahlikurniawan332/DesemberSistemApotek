<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn() => User::factory(),
            'no_transaction' => 'TRX-' . date('Ymd') . '-' . fake()->unique()->numberBetween(1000, 9999),
            'total' => fake()->numberBetween(10000, 50000),
        ];
    }
}

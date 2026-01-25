<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medicine_id' => Medicine::factory(),
            'user_id' => User::factory(),
            'no_batch' => strtoupper(fake()->bothify('BATCH-####??')),
            'tanggal_masuk' => fake()->dateTimeBetween('-1 years', 'now'),
            'tanggal_kadaluarsa' => fake()->dateTimeBetween('now', '+2 years'),
            'stok' => fake()->numberBetween(50, 200),
            'harga_beli' => fake()->numberBetween(5000, 50000),
            'harga_jual' => fake()->numberBetween(6000, 60000),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Batch;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jumlah = fake()->numberBetween(1, 10);
        $harga_jual = fake()->numberBetween(10000, 50000);
        $subtotal = $jumlah * $harga_jual;

        return [
            'transaction_id' => Transaction::factory(),
            'batch_id' => Batch::factory(),
            'jumlah' => $jumlah,
            'subtotal' => $subtotal,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => strtoupper(fake()->bothify('MED-####??')),
            'nama' => fake()->unique()->words(2, true),
            'satuan' => fake()->randomElement(['tablet', 'kapsul', 'botol', 'tube', 'sachet']),
            'kategori' => fake()->randomElement(['Analgesik', 'Antibiotik', 'Vitamin', 'Antiseptik', 'Antihipertensi']),
            'min_stok' => fake()->numberBetween(10, 100),
        ];
    }
}

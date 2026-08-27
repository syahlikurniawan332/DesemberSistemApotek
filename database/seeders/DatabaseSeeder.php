<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            $this->command?->warn('Data demo tidak dibuat di lingkungan production.');

            return;
        }

        $this->call([
            UserSeeder::class,
            MedicineSeeder::class,
            BatchSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}

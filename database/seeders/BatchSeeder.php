<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Batch::factory(10)->create([
            'medicine_id' => fn() => Medicine::all()->random(),
            'user_id' => fn() => User::all()->random(),
        ]);
    }
}

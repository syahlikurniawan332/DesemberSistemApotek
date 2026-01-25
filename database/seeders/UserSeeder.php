<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // membuat dummy spesifik 
        User::create([
            'name' => 'Admin Apotek',
            'email' => 'admin@example.com',
            'password' => FacadesHash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Apoteker Satu',
            'email' => 'apoteker@example.com',
            'password' => FacadesHash::make('password'),
            'role' => 'apoteker',
        ]);

        // buat dummy random 
        User::factory(3)->create();
    }
}

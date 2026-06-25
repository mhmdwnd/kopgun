<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::Create([
            'name' => 'Admin',
            'email' => 'admin@kopgun.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        user::create([
            'name' => 'Kasir',
            'email' => 'kasir@kopgun.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);
    }
}

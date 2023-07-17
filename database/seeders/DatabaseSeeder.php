<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create dummy account 1
        User::create([
            'username' => 'Jonnathan',
            'email' => 'jonnathan@gmail.com',
            'password' => Hash::make('jonnathan123'),
            'is_admin' => 1
        ]);

        // Create dummy account 2
        User::create([
            'username' => 'Wildan',
            'email' => 'wildan@gmail.com',
            'password' => Hash::make('wildan123'),
            'is_admin' => 1
        ]);
    }
}

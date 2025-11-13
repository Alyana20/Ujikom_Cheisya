<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@healthcare.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Test Customer User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'customer',
        ]);

        // Create Test Vendor User
        User::create([
            'name' => 'Vendor Toko',
            'email' => 'vendor@healthcare.com',
            'password' => bcrypt('vendor123'),
            'role' => 'vendor',
            'email_verified_at' => now(),
        ]);

        $this->call([
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

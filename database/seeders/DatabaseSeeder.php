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
        // ==================== ADMIN USERS ====================
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Admin Healthcare',
            'email' => 'admin@healthcare.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // ==================== VENDOR USERS ====================
        User::create([
            'name' => 'Vendor Toko Kesehatan',
            'email' => 'vendor@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'vendor',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Vendor Apotek',
            'email' => 'vendor@healthcare.com',
            'password' => bcrypt('vendor123'),
            'role' => 'vendor',
            'email_verified_at' => now(),
        ]);

        // ==================== CUSTOMER USERS ====================
        User::create([
            'name' => 'Suwito',
            'email' => 'suwito@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->call([
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

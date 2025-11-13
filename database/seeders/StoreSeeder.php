<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user dengan role 'vendor' atau buat user admin jika tidak ada
        $user = User::where('role', 'admin')->first()
            ?? User::create([
                'name' => 'Admin User',
                'email' => 'admin@healthcare.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

        Store::create([
            'user_id' => $user->id,
            'name' => 'Toko Alat Kesehatan Utama',
            'description' => 'Toko penyedia alat kesehatan terpercaya dengan produk berkualitas tinggi.',
            'address' => 'Jl. Kesehatan No. 123, Jakarta',
            'status' => 'approved'
        ]);

        echo "Store created successfully!\n";
    }
}

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
        // Store untuk vendor pertama
        $vendor1 = User::where('email', 'vendor@gmail.com')->first();
        if ($vendor1) {
            Store::create([
                'user_id' => $vendor1->id,
                'name' => 'Toko Alat Kesehatan Sehat',
                'description' => 'Toko penyedia alat kesehatan terpercaya dengan produk berkualitas tinggi.',
                'address' => 'Jl. Kesehatan No. 123, Jakarta',
                'phone' => '081234567890',
                'status' => 'approved'
            ]);
        }

        // Store untuk vendor kedua
        $vendor2 = User::where('email', 'vendor@healthcare.com')->first();
        if ($vendor2) {
            Store::create([
                'user_id' => $vendor2->id,
                'name' => 'Apotek Sehat Sejahtera',
                'description' => 'Apotek lengkap dengan layanan konsultasi gratis.',
                'address' => 'Jl. Apotek No. 456, Bandung',
                'phone' => '082345678901',
                'status' => 'approved'
            ]);
        }

        echo "Stores created successfully for vendors!\n";
    }
}

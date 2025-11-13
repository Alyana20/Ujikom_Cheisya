<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::first();

        if (!$store) {
            $user = User::where('role', 'admin')->first();
            if (!$user) {
                $user = User::create([
                    'name' => 'Admin User',
                    'email' => 'admin@healthcare.com',
                    'password' => bcrypt('password'),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]);
            }

            $store = Store::create([
                'user_id' => $user->id,
                'name' => 'Toko Alat Kesehatan Utama',
                'description' => 'Toko penyedia alat kesehatan terpercaya dengan produk berkualitas tinggi.',
                'address' => 'Jl. Kesehatan No. 123, Jakarta',
                'status' => 'approved'
            ]);
        }

        $products = [
            // OBAT
            [
                'store_id' => $store->id,
                'nama' => 'Paracetamol 500mg',
                'kategori' => 'Obat',
                'harga' => 25000,
                'deskripsi' => 'Obat pereda nyeri dan demam, mengandung Paracetamol 500mg per tablet.',
                'gambar' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop',
                'stok' => 100,
            ],
            [
                'store_id' => $store->id,
                'nama' => 'Antasida DO I',
                'kategori' => 'Obat',
                'harga' => 15000,
                'deskripsi' => 'Obat maag untuk meredakan gejala asam lambung berlebih.',
                'gambar' => 'https://images.unsplash.com/photo-1585435557343-3c1b5c6b8b4a?w=400&h=300&fit=crop',
                'stok' => 50,
            ],

            // SUPLEMEN
            [
                'store_id' => $store->id,
                'nama' => 'Vitamin C 1000mg',
                'kategori' => 'Suplemen',
                'harga' => 75000,
                'deskripsi' => 'Suplemen vitamin C dosis tinggi untuk daya tahan tubuh.',
                'gambar' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&h=300&fit=crop',
                'stok' => 30,
            ],
            [
                'store_id' => $store->id,
                'nama' => 'Omega-3 Fish Oil',
                'kategori' => 'Suplemen',
                'harga' => 120000,
                'deskripsi' => 'Suplemen omega-3 dari minyak ikan untuk kesehatan jantung.',
                'gambar' => 'https://images.unsplash.com/photo-1598047890523-70ac6c990d57?w=400&h=300&fit=crop',
                'stok' => 25,
            ],

            // ALAT TERAPI
            [
                'store_id' => $store->id,
                'nama' => 'Nebulizer Portable',
                'kategori' => 'Alat Terapi',
                'harga' => 350000,
                'deskripsi' => 'Alat terapi pernafasan portable untuk penggunaan di rumah.',
                'gambar' => 'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=400&h=300&fit=crop',
                'stok' => 15,
            ],
            [
                'store_id' => $store->id,
                'nama' => 'Tensimeter Digital',
                'kategori' => 'Alat Terapi',
                'harga' => 180000,
                'deskripsi' => 'Alat pengukur tekanan darah digital dengan hasil akurat.',
                'gambar' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=300&fit=crop',
                'stok' => 20,
            ],

            // PERALATAN MEDIS
            [
                'store_id' => $store->id,
                'nama' => 'Stetoskop Dual Head',
                'kategori' => 'Peralatan Medis',
                'harga' => 150000,
                'deskripsi' => 'Stetoskop profesional dengan dual head untuk diagnosis yang presisi.',
                'gambar' => 'https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=400&h=300&fit=crop',
                'stok' => 10,
            ],
            [
                'store_id' => $store->id,
                'nama' => 'Termometer Infrared',
                'kategori' => 'Peralatan Medis',
                'harga' => 280000,
                'deskripsi' => 'Termometer digital infrared tanpa kontak untuk pengukuran suhu yang higienis.',
                'gambar' => 'https://images.unsplash.com/photo-1584556812955-5ed6c6f3c4b0?w=400&h=300&fit=crop',
                'stok' => 12,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        echo "Products with images created successfully!\n";
    }
}

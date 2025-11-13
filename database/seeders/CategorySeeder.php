<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Alat Medis',
                'slug' => 'alat-medis',
                'description' => 'Peralatan medis dan kesehatan profesional',
                'icon' => '🩺'
            ],
            [
                'name' => 'Suplemen & Vitamin',
                'slug' => 'suplemen-vitamin',
                'description' => 'Suplemen nutrisi dan vitamin untuk kesehatan',
                'icon' => '💊'
            ],
            [
                'name' => 'Obat-obatan',
                'slug' => 'obat-obatan',
                'description' => 'Obat resep dan obat bebas',
                'icon' => '⚕️'
            ],
            [
                'name' => 'Perawatan Kulit',
                'slug' => 'perawatan-kulit',
                'description' => 'Produk perawatan kulit dan kosmetik',
                'icon' => '💆'
            ],
            [
                'name' => 'Peralatan Olahraga',
                'slug' => 'peralatan-olahraga',
                'description' => 'Alat olahraga dan fitness',
                'icon' => '🏃'
            ],
            [
                'name' => 'Masker & Perlengkapan Medis',
                'slug' => 'masker-perlengkapan',
                'description' => 'Masker, sarung tangan, dan perlengkapan medis lainnya',
                'icon' => '🧤'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        echo "Categories seeded successfully!\n";
    }
}

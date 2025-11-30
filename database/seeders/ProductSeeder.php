<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori
        $kategori1 = Category::create(['name' => 'Signature Cakes', 'slug' => 'signature-cakes']);
        $kategori2 = Category::create(['name' => 'Cookies', 'slug' => 'cookies']);
        $kategori3 = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        // 2. Buat Produk Contoh
        $products = [
            [
                'category_id' => $kategori1->id,
                'name' => 'Royal Dark Chocolate',
                'slug' => 'royal-dark-chocolate',
                'description' => 'Kue coklat premium dengan lapisan ganache 70% dark chocolate.',
                'price' => 250000,
                'stock' => 10,
                'image' => 'https://placehold.co/600x400/1a1a1a/8D6E63?text=Royal+Choco' // Gambar placeholder
            ],
            [
                'category_id' => $kategori1->id,
                'name' => 'Red Velvet Supreme',
                'slug' => 'red-velvet-supreme',
                'description' => 'Kelembutan red velvet dengan cream cheese asli.',
                'price' => 220000,
                'stock' => 15,
                'image' => 'https://placehold.co/600x400/1a1a1a/8D6E63?text=Red+Velvet'
            ],
            [
                'category_id' => $kategori2->id,
                'name' => 'Almond Crispy',
                'slug' => 'almond-crispy',
                'description' => 'Cookies renyah dengan taburan almond panggang.',
                'price' => 85000,
                'stock' => 50,
                'image' => 'https://placehold.co/600x400/1a1a1a/8D6E63?text=Almond+Crispy'
            ],
            [
                'category_id' => $kategori3->id,
                'name' => 'Butter Croissant',
                'slug' => 'butter-croissant',
                'description' => 'Croissant autentik dengan butter Prancis.',
                'price' => 25000,
                'stock' => 30,
                'image' => 'https://placehold.co/600x400/1a1a1a/8D6E63?text=Croissant'
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
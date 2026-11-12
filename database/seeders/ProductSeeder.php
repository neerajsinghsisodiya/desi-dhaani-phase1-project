<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'A2 Desi Cow Ghee - 500ml', 'type' => 'ghee', 'price' => 65000, 'stock' => 50],
            ['name' => 'A2 Desi Cow Ghee - 1L', 'type' => 'ghee', 'price' => 120000, 'stock' => 30],
            ['name' => 'Cold-Pressed Mustard Oil - 1L', 'type' => 'oil', 'price' => 35000, 'stock' => 40],
            ['name' => 'Cold-Pressed Groundnut Oil - 1L', 'type' => 'oil', 'price' => 38000, 'stock' => 40],
        ];

        foreach ($products as $p) {
            Product::create($p + [
                'slug' => Str::slug($p['name']),
                'description' => 'Authentic, traditionally made, and lab-tested for purity.',
                'is_active' => true,
            ]);
        }
    }
}

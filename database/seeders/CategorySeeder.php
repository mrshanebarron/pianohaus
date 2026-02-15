<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Grand Piano', 'description' => 'The pinnacle of piano design. Horizontal strings and full-size soundboard deliver unmatched tonal depth and dynamic range.', 'icon' => 'grand'],
            ['name' => 'Baby Grand', 'description' => 'All the elegance of a grand piano in a more compact footprint. Perfect for homes that demand both beauty and performance.', 'icon' => 'baby-grand'],
            ['name' => 'Upright Piano', 'description' => 'Vertical design maximizes sound in minimal space. The workhorse of studios, schools, and living rooms worldwide.', 'icon' => 'upright'],
            ['name' => 'Digital Piano', 'description' => 'Advanced sampling and weighted keys capture acoustic authenticity. Silent practice, recording capability, never needs tuning.', 'icon' => 'digital'],
            ['name' => 'Hybrid Piano', 'description' => 'Real acoustic action meets digital sound technology. The best of both worlds for the modern musician.', 'icon' => 'hybrid'],
        ];

        foreach ($categories as $i => $category) {
            Category::create(array_merge($category, ['sort_order' => $i]));
        }
    }
}

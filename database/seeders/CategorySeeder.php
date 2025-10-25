<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'General',     'color' => '#3b82f6'],
            ['name' => 'PHP',         'color' => '#8b5cf6'],
            ['name' => 'Laravel',     'color' => '#ef4444'],
            ['name' => 'JavaScript',  'color' => '#f59e0b'],
            ['name' => 'CSS',         'color' => '#10b981'],
        ];

        foreach ($items as $item) {
            Category::updateOrCreate(
                ['name' => $item['name']],
                ['color' => $item['color']]
            );
        }
        // 👇 NADA MÁS AQUÍ (no te llames a ti mismo)
    }
}

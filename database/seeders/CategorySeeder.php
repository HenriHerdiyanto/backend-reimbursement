<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Transportasi', 'limit_per_month' => 500000]);
        Category::create(['name' => 'Kesehatan', 'limit_per_month' => 1000000]);
        Category::create(['name' => 'Makan', 'limit_per_month' => 300000]);
        Category::create(['name' => 'Lainnya', 'limit_per_month' => 200000]);
    }
}

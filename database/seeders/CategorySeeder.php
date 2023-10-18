<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array('Electronics', 'Accessories', 'Softwares');
        $numOfCategories = count($categories);

        for ($i = 0; $i < $numOfCategories; $i++) {
            Category::create([
                'category_name' => $categories[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

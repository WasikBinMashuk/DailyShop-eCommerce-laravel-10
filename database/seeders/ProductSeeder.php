<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $products = [
            [
                'category_id' => 1,
                'sub_category_id' => 3,
                'product_code' => '1111',
                'product_name' => 'A.tech',
                'price' => '100',
                'product_image' => null,
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'sub_category_id' => 3,
                'product_code' => '1112',
                'product_name' => 'Mi',
                'price' => '100',
                'product_image' => null,
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Product::insert($products);
    }
}

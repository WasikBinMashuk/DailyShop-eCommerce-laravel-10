<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $categories = array('Electronics', 'Accessories', 'Softwares');
        // $numOfCategories = count($categories);

        // for ($i = 0; $i < $numOfCategories; $i++) {
        //     Category::create([
        //         'category_name' => $categories[$i],
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
        $sql = "insert  into `categories`(`id`,`category_name`,`created_at`,`updated_at`) values (1,'Electronics','2023-08-28 12:14:19','2023-08-30 06:13:19'),(2,'Accessories','2023-08-28 12:14:19','2023-08-28 12:14:19'),(3,'Softwares','2023-08-28 12:14:19','2023-08-28 12:14:19'),(4,'Clothing','2023-08-29 05:46:28','2023-08-29 05:46:28'),(5,'Grocery','2023-08-29 06:54:40','2023-08-29 06:54:40'),(8,'Plastic','2023-08-30 07:38:29','2023-08-30 07:38:29'),(9,'Health','2023-09-16 07:42:35','2023-09-16 07:42:35')";

        DB::statement($sql);
    }
}

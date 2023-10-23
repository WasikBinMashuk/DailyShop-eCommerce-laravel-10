<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $subCategories = array(
        //     array('TV', 'Freezer'),
        //     array('Mouse', 'Keyboard'),
        //     array('Antivirus', 'OS')
        // );

        // for ($i = 0; $i < 3; $i++) {
        //     for ($j = 0; $j < 2; $j++) {
        //         SubCategory::create([
        //             'category_id' => $i + 1,
        //             'sub_category_name' => $subCategories[$i][$j],
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);
        //     }
        // }

        $sql = "insert  into `sub_categories`(`id`,`category_id`,`sub_category_name`,`created_at`,`updated_at`) values (3,2,'Mouse','2023-08-28 12:14:19','2023-08-28 12:14:19'),(5,3,'Antivirus','2023-08-28 12:14:19','2023-08-28 12:14:19'),(7,4,'Men','2023-08-29 06:34:45','2023-08-30 07:25:23'),(8,1,'AC','2023-08-29 06:35:33','2023-08-29 06:35:33'),(10,1,'TV','2023-08-30 03:54:01','2023-08-30 03:54:01'),(11,5,'Flour','2023-08-30 03:58:23','2023-08-30 03:58:23'),(12,5,'Egg','2023-08-30 03:58:50','2023-08-30 03:58:50'),(14,1,'Laptop','2023-08-30 05:39:59','2023-08-30 05:39:59'),(15,3,'OS','2023-08-30 06:08:54','2023-08-30 06:08:54'),(16,3,'Avira antivirus v2','2023-08-30 06:14:15','2023-08-30 07:04:38'),(17,8,'Bottle','2023-08-31 09:53:52','2023-08-31 09:53:52'),(18,8,'Tiffin Box','2023-08-31 09:54:02','2023-08-31 09:54:02'),(19,3,'Photo Editing','2023-08-31 09:54:36','2023-08-31 09:54:36'),(20,4,'Women','2023-09-02 15:00:44','2023-09-02 15:00:44'),(21,2,'Keyboard','2023-09-03 06:36:32','2023-09-03 06:36:32'),(22,9,'Medicine','2023-09-16 07:42:46','2023-09-16 07:42:46');";

        DB::statement($sql);
    }
}

<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $subCategories = array(
            array('TV','Freezer'),
            array('Mouse','Keyboard'),
            array('Antivirus','OS')
        );

        for($i = 0; $i < 3; $i++){
            for($j=0; $j < 2; $j++){
                SubCategory::create([
                    'category_id' => $i+1,
                    'sub_category_name' => $subCategories[$i][$j],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

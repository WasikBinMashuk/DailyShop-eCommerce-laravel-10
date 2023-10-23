<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $sql = "insert  into `sliders`(`id`,`slider_title`,`slider_image`,`slider_link`,`status`,`created_at`,`updated_at`) values (5,'Explore All New iMac','1695017855.jpg','https://www.apple.com/mac/',1,'2023-09-18 04:27:56','2023-09-19 10:57:39'),(9,'Green Sofa','1695016886.jpg','https://www.pexels.com/photo/2-seat-orange-leather-sofa-beside-wall-1866149/',1,'2023-09-18 05:38:19','2023-09-18 06:01:28'),(10,'Black Sofa','1695015922.jpg','https://www.wallpaperflare.com/gray-fabric-couch-and-five-yellow-throw-pillows-sofa-furniture-wallpaper-svmg/download/1920x1080',1,'2023-09-18 05:45:24','2023-09-18 05:45:24')";

        DB::statement($sql);
    }
}

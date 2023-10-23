<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sql = "
        insert  into `products`(`id`,`category_id`,`sub_category_id`,`product_code`,`product_name`,`price`,`product_image`,`status`,`created_at`,`updated_at`,`description`,`trendy`) values (8,5,11,'111','ACI 2kg','100','111-1693724571.jpg',1,'2023-08-30 13:49:31','2023-09-03 07:02:51',NULL,0),(9,4,7,'112','Blue Shirt','2500','112-1693475518.jpg',0,'2023-08-30 13:50:22','2023-09-03 06:42:29',NULL,0),(11,2,3,'115','A4tech','122','115-1693475489.jpg',1,'2023-08-30 13:51:23','2023-09-04 07:27:35',NULL,0),(12,1,10,'22132','Samsung 32','32000','22132-1693475556.jpg',1,'2023-08-30 13:55:17','2023-09-24 06:21:15',NULL,0),(19,2,3,'123123','Dell','1200','123123-1693475466.jpg',1,'2023-08-31 09:32:39','2023-09-03 06:41:48',NULL,0),(20,8,17,'1121','RFL Water bottle','120','1121-1693724582.jpg',1,'2023-08-31 09:57:36','2023-09-03 07:03:02',NULL,0),(21,8,18,'2212','RFL Box','200','2212-1693724598.jpg',1,'2023-08-31 09:58:14','2023-09-03 07:03:18',NULL,0),(22,3,19,'3321','Adobe PS Key','2000','3321-1693724638.jpg',1,'2023-08-31 10:00:53','2023-09-03 07:03:58',NULL,0),(28,2,3,'2200','Logitech','2200','2200-1693641725.jpg',1,'2023-09-02 08:00:25','2023-09-03 06:41:39',NULL,0),(31,4,7,'988','Pants','2200','98-1693643234.jpg',1,'2023-09-02 08:25:29','2023-09-17 03:56:51','<p><strong>All sizes available.</strong></p>',0),(34,3,15,'3232','Ubuntu','600','3232-1693668397.png',1,'2023-09-02 15:01:23','2023-09-17 03:56:04','<p>Product type: Retail key.</p>',0),(35,2,21,'2010','A4tech Keyboard','400','2010-1693723055.jpg',1,'2023-09-03 06:37:35','2023-09-17 03:55:33','<p><strong>Color: Black</strong></p>\r\n<p><strong>Warranty: 1 year.</strong></p>',0),(38,1,10,'6596','Walton','35000','6596-1693799062.jpg',1,'2023-09-04 03:43:41','2023-09-17 03:55:03','<p><strong>Specs: 32\" 4k</strong></p>',0),(39,1,14,'6500','Asus laptop','65005','6500-1694669601.jpg',1,'2023-09-07 04:26:14','2023-09-17 11:50:04','<p><strong>3 Years warranty.</strong></p>',1),(59,1,8,'9699','Toshiba','6900','9699-1694670702.jpg',1,'2023-09-14 05:51:42','2023-09-17 11:31:42','<p style=\"text-align: left;\"><em><strong>Warranty Lifetime.</strong></em></p>',1),(60,9,22,'333','Entacid Liquid','100','333-1694926486.jpg',1,'2023-09-17 04:54:47','2023-09-17 11:31:38','<p><strong>Medicine for acidity.</strong></p>',1),(61,1,8,'9636','Gree AC','90000','9636-1694938541.jpg',1,'2023-09-17 08:15:42','2023-09-17 09:45:05',NULL,1),(62,9,22,'0121','Insulin','600','0121-1694943485.jpg',1,'2023-09-17 08:16:39','2023-10-21 08:11:28','<p><strong>To treat Diabetes.</strong></p>',1),(63,4,7,'33210','Wasik Lungi','1200','33210-1695200364.jpg',1,'2023-09-20 08:59:24','2023-10-02 09:17:46',NULL,0)";

        DB::statement($sql);
    }
}

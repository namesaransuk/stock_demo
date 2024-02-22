<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();

        \DB::table('categories')->insert([
                [
                    'id' => 1,
                    'name' => 'เครื่องสำอาง',
                    'product_import_flag' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'อาหารเสริม',
                    'product_import_flag' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'บรรจุภัณฑ์',
                    'product_import_flag' => 0,
                    'record_status' => 1,
                ],
                [
                    'id' => 4,
                    'name' => 'ผลิตภัณฑ์สำเร็จรูป',
                    'product_import_flag' => 0,
                    'record_status' => 1,
                ],
                [
                    'id' => 5,
                    'name' => 'วัสดุสิ้นเปลือง',
                    'product_import_flag' => 0,
                    'record_status' => 1,
                ],
            ]
        );
    }
}

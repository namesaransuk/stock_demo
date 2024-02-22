<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('product_units')->delete();

        \DB::table('product_units')->insert([
                [
                    'id' => 1,
                    'name' => 'กล่องเล็ก บรรจุ 10 ซอง',
                    'multiply' => 10,
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'กล่องกลาง บรรจุ 50 ซอง',
                    'multiply' => 50,
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'กล่องใหญ่ บรรจุ 100 ซอง',
                    'multiply' => 100,
                    'record_status' => 1,
                ],
                [
                    'id' => 4,
                    'name' => 'ลังเล็ก บรรจุ 50 กล่อง',
                    'multiply' => 50,
                    'record_status' => 1,
                ],
                [
                    'id' => 5,
                    'name' => 'ลังกลาง บรรจุ 150 กล่อง',
                    'multiply' => 150,
                    'record_status' => 1,
                ],
                [
                    'id' => 6,
                    'name' => 'ลังใหญ่ บรรจุ 300 กล่อง',
                    'multiply' => 300,
                    'record_status' => 1,
                ],
            ]
        );
    }
}

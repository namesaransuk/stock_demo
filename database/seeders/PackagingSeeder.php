<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('packagings')->delete();

        \DB::table('packagings')->insert([
                [
                    'id' => 1,
                    'name' => 'ขวดพลาสติก ขนาดเล็ก 125ml.',
                    'is_active' => 1,
                    'weight_per_qty' => 125,
                    'volumetric_unit' => 'ml.',
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'ซองครีม ขนาดเล็ก 100g.',
                    'is_active' => 1,
                    'weight_per_qty' => 100,
                    'volumetric_unit' => 'g.',
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'ขวดอลูมิเนียม ขนาดใหญ่ 550ml.',
                    'is_active' => 1,
                    'weight_per_qty' => 550,
                    'volumetric_unit' => 'ml.',
                    'record_status' => 1,
                ],
                [
                    'id' => 4,
                    'name' => 'กล่องขนาดใหญ่',
                    'is_active' => 1,
                    'weight_per_qty' => 150,
                    'volumetric_unit' => 'pcs.',
                    'record_status' => 1,
                ],

            ]
        );
    }
}

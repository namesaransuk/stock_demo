<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('materials')->delete();

        \DB::table('materials')->insert([
                [
                    'name' => 'RM-001',
                    'trade_name' => 'RM-001',
                    'is_active' => 1,
                    'record_status' => 1,
                    'category_id' => 1,
                ],
                [
                    'name' => 'RM-002',
                    'trade_name' => 'RM-002',
                    'is_active' => 1,
                    'record_status' => 1,
                    'category_id' => 1,
                ],
            ]
        );
    }
}

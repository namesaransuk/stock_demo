<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReceiveSupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('receive_supplies')->delete();

        \DB::table('receive_supplies')->insert([
                [
                    'paper_no' => 'SM-01',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 2,
                    'created_by' => 2,
                    'updated_by' => 9,
                    'brand_vendor_id' => 10,
                ],
                [
                    'paper_no' => 'SM-02',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 9,
                    'created_by' => 2,
                    'updated_by' => 9,
                    'brand_vendor_id' => 10,
                ],
                [
                    'paper_no' => 'SM-03',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 16,
                    'created_by' => 2,
                    'updated_by' => 9,
                    'brand_vendor_id' => 10,
                ],
            ]
        );
    }
}

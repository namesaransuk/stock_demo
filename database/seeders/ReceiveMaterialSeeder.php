<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReceiveMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('receive_materials')->delete();

        \DB::table('receive_materials')->insert([
                [
                    'paper_no' => 'FM-QC-01',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 2,
                    'brand_vendor_id' => 8,
                    'logistic_vendor_id' => 9,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
                [
                    'paper_no' => 'FM-QC-02',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 9,
                    'brand_vendor_id' => 7,
                    'logistic_vendor_id' => 9,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
                [
                    'paper_no' => 'FM-QC-03',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 16,
                    'brand_vendor_id' => 8,
                    'logistic_vendor_id' => 9,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReceivePackagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('receive_packagings')->delete();

        \DB::table('receive_packagings')->insert([
                [
                    'paper_no' => 'FP-QC-01',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 2,
                    'brand_vendor_id' => 1,
                    'logistic_vendor_id' => 4,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
                [
                    'paper_no' => 'FP-QC-02',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 9,
                    'brand_vendor_id' => 2,
                    'logistic_vendor_id' => 5,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
                [
                    'paper_no' => 'FP-QC-03',
                    'edit_times' => 0,
                    'date' => $date,
                    'stock_user_id' => 16,
                    'brand_vendor_id' => 3,
                    'logistic_vendor_id' => 6,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
            ]
        );
    }
}

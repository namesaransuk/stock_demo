<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReceiveProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('receive_products')->delete();

        \DB::table('receive_products')->insert([
                [
                    'paper_no' => 'FS-QC-01',
                    'edit_times' => 0,
                    'date' => $date,
                    'production_user_id' => 4,
                    'stock_user_id' => 2,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
                [
                    'paper_no' => 'FS-QC-02',
                    'edit_times' => 0,
                    'date' => $date,
                    'production_user_id' =>11,
                    'stock_user_id' => 9,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
                [
                    'paper_no' => 'FS-QC-03',
                    'edit_times' => 0,
                    'date' => $date,
                    'production_user_id' => 18,
                    'stock_user_id' => 16,
                    'created_by' => 2,
                    'updated_by' => 9,
                ],
            ]
        );
    }
}

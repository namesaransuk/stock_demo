<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('product_lots')->delete();

        \DB::table('product_lots')->insert([
            //receive
                [
                    'lot' => 'OC-P-210802-0001',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 1,
                    'receive_product_id' => 1,
                    'product_id' => 1,
                    'unit_id' => 1,

                ],
                [
                    'lot' => 'OC-P-210802-0001',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 2,
                    'product_id' => 1,
                    'receive_product_id' => 2,
                    'unit_id' => 1,

                ],
                [
                    'lot' => 'OC-P-210802-0001',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 3,
                    'product_id' => 1,
                    'receive_product_id' => 3,
                    'unit_id' => 1,

                ],
            ]
        );
    }
}

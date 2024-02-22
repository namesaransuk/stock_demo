<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackagingLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('packaging_lots')->delete();

        \DB::table('packaging_lots')->insert([
            //receive
                [

                    'lot' => 'OC-B-210802-0001',
                    'coa' => 'coa_test.pdf',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 1,
                    'packaging_id' => 4,
                    'receive_packaging_id' => 1,
                ],
                [

                    'lot' => 'OG-B-210802-0001',
                    'coa' => 'coa_test.pdf',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 2,
                    'packaging_id' => 4,
                    'receive_packaging_id' => 2,
                ],
                [

                    'lot' => 'OI-B-210802-0001',
                    'coa' => 'coa_test.pdf',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 2,
                    'packaging_id' => 4,
                    'receive_packaging_id' => 3,
                ],
            ]
        );
    }
}

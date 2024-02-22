<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaterialLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('material_lots')->delete();

        \DB::table('material_lots')->insert([
            //receive
                [
                    'lot' => 'OC-M-210802-0001',
                    'coa' => 'coa_test.pdf',
                    'weight_grams' => 500,
                    'weight_kg' => 30,
                    'weight_ton' => 1,
                    'weight_total' => 1030500,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'quality_check' => 1,
                    'transport_check' => 0,
                    'company_id' => 1,
                    'receive_mat_name' => "MAT01",
                    'receive_material_id' => 1,
                ],
                [

                    'lot' => 'OG-M-210802-0001',
                    'coa' => 'coa_test.pdf',
                    'weight_grams' => 500,
                    'weight_kg' => 30,
                    'weight_ton' => 1,
                    'weight_total' => 1030500,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'quality_check' => 0,
                    'transport_check' => 0,
                    'company_id' => 2,
                    'receive_mat_name' => "MAT02",
                    'receive_material_id' => 2,
                ],
                [
                    'lot' => 'OI-M-210802-0001',
                    'coa' => 'coa_test.pdf',
                    'weight_grams' => 500,
                    'weight_kg' => 30,
                    'weight_ton' => 1,
                    'weight_total' => 1030500,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'quality_check' => 0,
                    'transport_check' => 0,
                    'company_id' => 2,
                    'receive_mat_name' => "MAT03",
                    'receive_material_id' => 3,
                ],
                [
                    'lot' => 'REQUISITION-TEST 01',
                    'coa' => 'coa_test.pdf',
                    'weight_grams' => 0,
                    'weight_kg' => 0,
                    'weight_ton' => 5,
                    'weight_total' => 5000000,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 4,
                    'quality_check' => 1,
                    'transport_check' => 1,
                    'company_id' => 1,
                    'receive_mat_name' => "MAT04",
                    'receive_material_id' => 0,
                ],
            ]
        );
    }
}

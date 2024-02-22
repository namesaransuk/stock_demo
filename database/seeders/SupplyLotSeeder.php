<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplyLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('supply_lots')->delete();

        \DB::table('supply_lots')->insert([
            //receive
                [
                    'lot' => 'OC-SM-210802-0001',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 1,
                    'receive_supply_id' => 1,
                    'supply_id' => 1,
                ],
                [
                    'lot' => 'OG-SM-210802-0001',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 2,
                    'supply_id' => 1,
                    'receive_supply_id' => 2,
                ],
                [
                    'lot' => 'OI-SM-210802-0001',
                    'qty' => 100,
                    'mfg' => $date,
                    'exp' => $date,
                    'action' => 1,
                    'company_id' => 3,
                    'supply_id' => 1,
                    'receive_supply_id' => 3,
                ],
            ]
        );
    }
}

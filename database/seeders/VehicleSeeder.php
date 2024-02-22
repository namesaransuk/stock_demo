<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vehicles')->delete();

        \DB::table('vehicles')->insert([
                [
                    'id' => 1,
                    'brand' => 'Toyota',
                    'model' => 'Revo',
                    'plate' => 'อค 0001',
                    'company_id' => 1,
                ],
                [
                    'id' => 2,
                    'brand' => 'Mitsubishi',
                    'model' => 'Triton',
                    'plate' => 'อค 0002',
                    'company_id' => 1,
                ],
                [
                    'id' => 3,
                    'brand' => 'Toyota',
                    'model' => 'Revo',
                    'plate' => 'อก 0001',
                    'company_id' => 2,
                ],
                [
                    'id' => 4,
                    'brand' => 'Mitsubishi',
                    'model' => 'Triton',
                    'plate' => 'อก 0002',
                    'company_id' => 2,
                ],
                [
                    'id' => 5,
                    'brand' => 'Toyota',
                    'model' => 'Revo',
                    'plate' => 'ออ 0001',
                    'company_id' => 3,
                ],
                [
                    'id' => 6,
                    'brand' => 'Mitsubishi',
                    'model' => 'Triton',
                    'plate' => 'ออ 0002',
                    'company_id' => 3,
                ],

            ]
        );
    }
}

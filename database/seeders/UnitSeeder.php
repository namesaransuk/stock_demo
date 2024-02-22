<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('units')->delete();

        \DB::table('units')->insert([
                [
                    'id' => 1,
                    'name' => 'ซอง',
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'ขวด',
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'หลอด',
                    'record_status' => 1,
                ],
            ]
        );
    }
}

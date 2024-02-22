<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('prefixes')->delete();

        \DB::table('prefixes')->insert([
                [
                    'id' => 1,
                    'name' => 'นาย',
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'นาง',
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'นางสาว',
                    'record_status' => 1,
                ],
            ]
        );
    }
}

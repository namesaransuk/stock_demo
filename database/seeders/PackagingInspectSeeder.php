<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackagingInspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = '2021-08-02 09:00:00';
        \DB::table('packaging_inspects')->delete();

        \DB::table('packaging_inspects')->insert([
                [

                ],
            ]
        );
    }
}

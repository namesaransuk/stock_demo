<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->delete();

        \DB::table('products')->insert([
                [
                    'id' => 1,
                    'name' => 'Product A',
                    'category_id' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'Product B',
                    'category_id' => 1,
                    'record_status' => 1,
                ],
            ]
        );
    }
}

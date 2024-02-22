<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_companies')->delete();

        \DB::table('user_companies')->insert([
            //admin
                [
                    'user_id' => 1,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 1,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 1,
                    'company_id' => 3,
                ],
            //1st Company
                [
                    'user_id' => 2,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 3,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 4,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 5,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 6,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 7,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 8,
                    'company_id' => 1,
                ],
                //2nd Company
                [
                    'user_id' => 9,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 10,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 11,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 12,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 13,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 14,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 15,
                    'company_id' => 3,
                ],
                //3rd Company
                [
                    'user_id' => 16,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 17,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 18,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 19,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 20,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 21,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 22,
                    'company_id' => 3,
                ],

                //ชุดใหม่
                [
                    'user_id' => 23,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 24,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 25,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 26,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 27,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 28,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 29,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 30,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 31,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 32,
                    'company_id' => 1,
                ],
                [
                    'user_id' => 33,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 34,
                    'company_id' => 3,
                ],
                [
                    'user_id' => 35,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 36,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 37,
                    'company_id' => 2,
                ],
                [
                    'user_id' => 38,
                    'company_id' => 2,
                ],
            ]
        );
    }
}

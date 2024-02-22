<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_roles')->delete();

        \DB::table('user_roles')->insert([
                [
                    'id' => 1,
                    'user_id' => 1,
                    'role_id' => 1,
                ],
            //คอสเม่
                [
                    'id' => 2,
                    'user_id' => 2,
                    'role_id' => 2,
                ],
                [
                    'id' => 3,
                    'user_id' => 3,
                    'role_id' => 3,
                ],
                [
                    'id' => 4,
                    'user_id' => 4,
                    'role_id' => 4,
                ],
                [
                    'id' => 5,
                    'user_id' => 5,
                    'role_id' => 5,
                ],
                [
                    'id' => 6,
                    'user_id' => 6,
                    'role_id' => 6,
                ],
                [
                    'id' => 7,
                    'user_id' => 7,
                    'role_id' => 7,
                ],
                [
                    'id' => 8,
                    'user_id' => 8,
                    'role_id' => 8,
                ],
                //กรีนฟาร์ม
                [
                    'id' => 9,
                    'user_id' => 9,
                    'role_id' => 2,
                ],
                [
                    'id' => 10,
                    'user_id' => 10,
                    'role_id' => 3,
                ],
                [
                    'id' => 11,
                    'user_id' => 11,
                    'role_id' => 4,
                ],
                [
                    'id' => 12,
                    'user_id' => 12,
                    'role_id' => 5,
                ],
                [
                    'id' => 13,
                    'user_id' => 13,
                    'role_id' => 6,
                ],
                [
                    'id' => 14,
                    'user_id' => 14,
                    'role_id' => 7,
                ],
                [
                    'id' => 15,
                    'user_id' => 15,
                    'role_id' => 13,
                ],
                //อินโนเวชั่น
                [
                    'id' => 16,
                    'user_id' => 16,
                    'role_id' => 14,
                ],
                [
                    'id' => 17,
                    'user_id' => 17,
                    'role_id' => 3,
                ],
                [
                    'id' => 18,
                    'user_id' => 18,
                    'role_id' => 4,
                ],
                [
                    'id' => 19,
                    'user_id' => 19,
                    'role_id' => 5,
                ],
                [
                    'id' => 20,
                    'user_id' => 20,
                    'role_id' => 6,
                ],
                [
                    'id' => 21,
                    'user_id' => 21,
                    'role_id' => 7,
                ],
                [
                    'id' => 22,
                    'user_id' => 22,
                    'role_id' => 8,
                ],

                //ชุดใหม่
                [
                    'id' => 23,
                    'user_id' => 23,
                    'role_id' => 9,
                ],
                [
                    'id' => 24,
                    'user_id' => 24,
                    'role_id' => 9,
                ],
                [
                    'id' => 25,
                    'user_id' => 25,
                    'role_id' => 9,
                ],
                [
                    'id' => 26,
                    'user_id' => 26,
                    'role_id' => 10,
                ],
                [
                    'id' => 27,
                    'user_id' => 27,
                    'role_id' => 10,
                ],
                [
                    'id' => 28,
                    'user_id' => 28,
                    'role_id' => 10,
                ],
                [
                    'id' => 29,
                    'user_id' => 29,
                    'role_id' => 11,
                ],
                [
                    'id' => 30,
                    'user_id' => 30,
                    'role_id' => 11,
                ],
                [
                    'id' => 31,
                    'user_id' => 31,
                    'role_id' => 11,
                ],
                [
                    'id' => 32,
                    'user_id' => 32,
                    'role_id' => 12,
                ],
                [
                    'id' => 33,
                    'user_id' => 33,
                    'role_id' => 12,
                ],
                [
                    'id' => 34,
                    'user_id' => 34,
                    'role_id' => 12,
                ],
                [
                    'id' => 35,
                    'user_id' => 35,
                    'role_id' => 13,
                ],
                [
                    'id' => 36,
                    'user_id' => 36,
                    'role_id' => 14,
                ],
                [
                    'id' => 37,
                    'user_id' => 37,
                    'role_id' => 15,
                ],
                [
                    'id' => 38,
                    'user_id' => 38,
                    'role_id' => 16,
                ],
            ]
        );
    }
}

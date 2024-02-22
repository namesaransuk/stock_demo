<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('123456');
        \DB::table('users')->delete();

        \DB::table('users')->insert([
                [
                    'email' => 'admin@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 1,
                ],
                //stock
                [
                    'email' => 'stock1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 2,
                ],
                [
                    'email' => 'stock2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 9,
                ],
                [
                    'email' => 'stock3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 16,
                ],
                //audit
                [
                    'email' => 'audit1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 3,
                ],
                [
                    'email' => 'audit2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 10,
                ],
                [
                    'email' => 'audit3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 17,
                ],
                //production
                [
                    'email' => 'production1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 4,
                ],
                [
                    'email' => 'production2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 11,
                ],
                [
                    'email' => 'production3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 18,
                ],
                //procurement
                [
                    'email' => 'procurement1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 5,
                ],
                [
                    'email' => 'procurement2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 12,
                ],
                [
                    'email' => 'procurement3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 19,
                ],
                //qc
                [
                    'email' => 'qc1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 6,
                ],
                [
                    'email' => 'qc2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 13,
                ],
                [
                    'email' => 'qc3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 20,
                ],
                //transport
                [
                    'email' => 'transport1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 7,
                ],
                [
                    'email' => 'transport2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 14,
                ],
                [
                    'email' => 'transport3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 21,
                ],
                //account
                [
                    'email' => 'account1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 8,
                ],
                [
                    'email' => 'account2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 15,
                ],
                [
                    'email' => 'account3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 22,
                ],

                //ชุดใหม่
                [
                    'email' => 'stock-viewer1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 23,
                ],
                [
                    'email' => 'stock-viewer2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 24,
                ],
                [
                    'email' => 'stock-viewer3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 25,
                ],
                [
                    'email' => 'packaging-supply1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 26,
                ],
                [
                    'email' => 'packaging-supply2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 27,
                ],
                [
                    'email' => 'packaging-supply3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 28,
                ],
                [
                    'email' => 'material1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 29,
                ],
                [
                    'email' => 'material2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 30,
                ],
                [
                    'email' => 'material3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 31,
                ],
                [
                    'email' => 'finishproduct1@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 32,
                ],
                [
                    'email' => 'finishproduct2@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 33,
                ],
                [
                    'email' => 'finishproduct3@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 34,
                ],
                [
                    'email' => 'qc-material@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 35,
                ],
                [
                    'email' => 'qc-packaging@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 36,
                ],
                [
                    'email' => 'stock-material@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 37,
                ],
                [
                    'email' => 'stock-packaging@stock.com',
                    'password' => $password,
                    'status' => 1,
                    'emp_id' => 38,
                ],
            ]
        );
    }
}

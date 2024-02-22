<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('supplies')->delete();

        \DB::table('supplies')->insert([
                [
                    'name' => 'หมึกดำ',
                ],
                [
                    'name' => 'หมึกสี (แดง)',
                ],
                [
                    'name' => 'หมึกสี (เขียว)',
                ],
                [
                    'name' => 'หมึกสี (น้ำเงิน)',
                ],
                [
                    'name' => 'กรรไกร',
                ],
                [
                    'name' => 'คลิปหนีบกระดาษ',
                ],
                [
                    'name' => 'สก็อตเทป (แบบใส)',
                ],
                [
                    'name' => 'สก็อตเทป (แบบขุ่น)',
                ],
                [
                    'name' => 'กระดาษ A4',
                ],
                [
                    'name' => 'เครื่องเย็บกระดาษ',
                ],
                [
                    'name' => 'ลวดเย็บกระดาษ',
                ],



        ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InspectTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('inspect_templates')->delete();

        \DB::table('inspect_templates')->insert([
                [
                    'id' => 1,
                    'name' => 'แบบฟอร์มการตรวจสอบเครื่องสำอาง',
                    'category_id' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'แบบฟอร์มการตรวจสอบอาหารเสริม',
                    'category_id' => 2,
                ],
                [
                    'id' => 3,
                    'name' => 'แบบฟอร์มการตรวจสอบบรรจุภัณฑ์',
                    'category_id' => 3,
                ],
                [
                    'id' => 4,
                    'name' => 'แบบฟอร์มการตรวจสอบผลิตภัณฑ์สำเร็จรูป',
                    'category_id' => 4,
                ],
            ]
        );
    }
}

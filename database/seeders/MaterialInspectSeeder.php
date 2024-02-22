<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaterialInspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('material_inspects')->delete();

        \DB::table('material_inspects')->insert([
                [
                    'ins_template_name' => "แบบฟอร์มการตรวจสอบเครื่องสำอาง",
                    'ins_topic' => 'ลักษณะภายนอก',
                    'ins_type' => 1,
                    'ins_method' => 'สังเกตด้วยตา',
                    'sequence' => 1,
                    'inspect_template_id' => 1,
                    'material_lot_id' => 1,
                ],
                [
                    'ins_template_name' => "แบบฟอร์มการตรวจสอบเครื่องสำอาง",
                    'ins_topic' => 'ความเป็น กรด-เบส',
                    'ins_type' => 1,
                    'ins_method' => 'กระดาษยูนิเวอร์ซัลอินดิเคเตอร์',
                    'sequence' => 2,
                    'inspect_template_id' => 1,
                    'material_lot_id' => 1,
                ],
                [
                    'ins_template_name' => "แบบฟอร์มการตรวจสอบเครื่องสำอาง",
                    'ins_topic' => 'ผลการตรวจสอบ',
                    'ins_type' => 2,
                    'ins_method' => 'ผลการตรวจสอบ',
                    'sequence' => 3,
                    'inspect_template_id' => 1,
                    'material_lot_id' => 1,
                ],
            ]
        );
    }
}

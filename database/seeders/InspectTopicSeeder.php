<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InspectTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('inspect_topics')->delete();

        \DB::table('inspect_topics')->insert([
                [
                    'id' => 1,
                    'name' => 'ลักษณะภายนอก',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'ความเป็น กรด-เบส',
                    'method' => 'กระดาษยูนิเวอร์ซัลอินดิเคเตอร์',
                    'category_id' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'สภาพการขนส่ง',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 2,
                ],
                [
                    'id' => 4,
                    'name' => 'สภาพการบรรจุ',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 2,
                ],
                [
                    'id' => 5,
                    'name' => 'ลักษณะปรากฏทั่วไป',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 2,
                ],
                [
                    'id' => 6,
                    'name' => 'ดมกลิ่น',
                    'method' => 'ใช้ประสาทสัมผัส',
                    'category_id' => 2,
                ],
                [
                    'id' => 7,
                    'name' => 'ความชื้น',
                    'method' => 'ใช้ประสาทสัมผัส',
                    'category_id' => 2,
                ],
                [
                    'id' => 8,
                    'name' => 'สิ่งแปลกปลอม',
                    'method' => 'ใช้ประสาทสัมผัส',
                    'category_id' => 2,
                ],
                [
                    'id' => 9,
                    'name' => 'ชนิดวัสดุที่ใช้',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 3,
                ],
                [
                    'id' => 10,
                    'name' => 'ลักษณะภายนอก',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 3,
                ],
                [
                    'id' => 11,
                    'name' => 'ลักษณะของพื้นผิว',
                    'method' => 'สัมผัสด้วยมือ',
                    'category_id' => 3,
                ],
                [
                    'id' => 12,
                    'name' => 'ปริมาตรบรรจุเฉลี่ย',
                    'method' => 'ตวงด้วยกระบอกตวง / เครื่องชั่ง',
                    'category_id' => 3,
                ],
                [
                    'id' => 13,
                    'name' => 'ขนาดวัสดุบรรจุ',
                    'method' => 'เวอร์เนีย',
                    'category_id' => 3,
                ],
                [
                    'id' => 14,
                    'name' => 'น้ำหนักเฉลี่ย',
                    'method' => 'ชั่งด้วยเครื่องชั่ง',
                    'category_id' => 3,
                ],
                [
                    'id' => 15,
                    'name' => 'รอยรั่ว',
                    'method' => 'แช่วัสดุบรรจุในน้ำ',
                    'category_id' => 3,
                ],
                [
                    'id' => 16,
                    'name' => 'ตัวพิมพ์ / สกรีน (ถ้ามี)',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 3,
                ],
                [
                    'id' => 17,
                    'name' => 'ลักษณะภายนอก',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 4,
                ],
                [
                    'id' => 18,
                    'name' => 'สติกเกอร์ หน้า - หลัง',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 4,
                ],
                [
                    'id' => 19,
                    'name' => 'กล่องบรรจุ',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 4,
                ],
                [
                    'id' => 20,
                    'name' => 'ชริ้ง',
                    'method' => 'สังเกตด้วยตา',
                    'category_id' => 4,
                ],
                [
                    'id' => 21,
                    'name' => 'น้ำหนัก',
                    'method' => 'ชั่งน้ำหนัก',
                    'category_id' => 4,
                ],
            ]
        );
    }
}

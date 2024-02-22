<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vendors')->delete();

        \DB::table('vendors')->insert([
                [
                    'id' => 1,
                    'brand' => 'Boxing Builder Co., Ltd.',
                    'address' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'contact_number' => '0800000001',
                    'contact_name' => 'นายสมหมาย ใจดี',
                    'type' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'brand' => 'Bottle Innovative Co., Ltd.',
                    'address' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'contact_number' => '0800000002',
                    'contact_name' => 'นายสุชาติ พันธุ์ไทย',
                    'type' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'brand' => 'Advanced Innovation Management Co.,Ltd ',
                    'address' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'contact_number' => '0800000003',
                    'contact_name' => 'นางสาวสมใจ สมราคา',
                    'type' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 4,
                    'brand' => 'Kerry Express Thailand',
                    'address' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'contact_number' => '0900000004',
                    'contact_name' => 'นายนะโม สามจบ',
                    'type' => 2,
                    'record_status' => 1,
                ],
                [
                    'id' => 5,
                    'brand' => 'J&T Express Thailand',
                    'address' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'contact_number' => '0900000005',
                    'contact_name' => 'นางสาวอาเมน สถิตย์',
                    'type' => 2,
                    'record_status' => 1,
                ],
                [
                    'id' => 6,
                    'brand' => 'FedEx Express Thailand',
                    'address' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'contact_number' => '0900000006',
                    'contact_name' => 'นายบรรจง บรรพกาล',
                    'type' => 2,
                    'record_status' => 1,
                ],
                [
                    'id' => 7,
                    'brand' => 'JEBSEN & JESSEN',
                    'address' => '23 สุขุมวิท ซ. 63 แขวง คลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110',
                    'contact_number' => '027878888',
                    'contact_name' => 'Itchaya Savanayana',
                    'type' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 8,
                    'brand' => 'Acai Industry',
                    'address' => '23 สุขุมวิท ซ. 63 แขวง คลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110',
                    'contact_number' => '0900000008',
                    'contact_name' => 'นางหว่อง ไวไว',
                    'type' => 1,
                    'record_status' => 1,
                ],
                [
                    'id' => 9,
                    'brand' => 'Flash Express Thailand',
                    'address' => '23 สุขุมวิท ซ. 63 แขวง คลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110',
                    'contact_number' => '0900000009',
                    'contact_name' => 'นายปฏิเสธ สมรส',
                    'type' => 2,
                    'record_status' => 1,
                ],
                [
                    'id' => 10,
                    'brand' => 'ร้านวัสดุสำนักงานครบวงจร',
                    'address' => '23 สุขุมวิท ซ. 63 แขวง คลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110',
                    'contact_number' => '0900000009',
                    'contact_name' => 'นายกัน สมรส',
                    'type' => 1,
                    'record_status' => 1,
                ],

            ]
        );
    }
}

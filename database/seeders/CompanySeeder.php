<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->delete();

        \DB::table('companies')->insert([
                [
                    'id' => 1,
                    'name_th' => 'บริษัท ออกานิกส์ คอสเม่ จำกัด',
                    'name_en' => 'Organics Cosme Co., Ltd.',
                    'email' => 'contact@organicscosme.com',
                    'address_th' => '87/5 หมู่ 2 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000 (สำนักงานใหญ่)
                    78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000 (สำนักงานสาขา)',
                    'address_en' => 'english address',
                    'website' => 'www.organicscosme.com',
                    'contact_number' => '094-519-2222',
                    'logo' => 'logo_organics_cosme.jpg',
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name_th' => 'บริษัท ออกานิกส์ กรีนฟาร์ม จำกัด',
                    'name_en' => 'Organics Greens Farm Co., Ltd.',
                    'email' => '-',
                    'address_th' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'address_en' => 'english address',
                    'website' => '-',
                    'contact_number' => '094-519-2222',
                    'logo' => 'logo_organics_greens_farm.jpg',
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'name_th' => 'บริษัท ออกานิกส์ อินโนเวชั่นส์ จำกัด',
                    'name_en' => 'Organics Innovations Co., Ltd.',
                    'email' => '-',
                    'address_th' => '78/9 หมู่ 3 ต.บ่อพลับ อ.เมือง จ.นครปฐม 73000',
                    'address_en' => 'english address',
                    'website' => '-',
                    'contact_number' => '094-519-2222',
                    'logo' => 'logo_organics_innovations.jpg',
                    'record_status' => 1,
                ]


            ]
        );
    }
}

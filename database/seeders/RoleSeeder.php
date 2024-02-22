<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        \DB::table('roles')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Admin (แอดมินระบบ)',
                    'code' => 'AM',
                    'record_status' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'Stock (ฝ่ายคลัง)',
                    'code' => 'ST',
                    'record_status' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'Audit (ฝ่ายตรวจสอบ)',
                    'code' => 'AD',
                    'record_status' => 1,
                ],
                [
                    'id' => 4,
                    'name' => 'Production (ฝ่ายผลิต)',
                    'code' => 'PD',
                    'record_status' => 1,
                ],
                [
                    'id' => 5,
                    'name' => 'Procurement (ฝ่ายจัดซื้อ)',
                    'code' => 'PC',
                    'record_status' => 1,
                ],
                [
                    'id' => 6,
                    'name' => 'Qc (ฝ่ายควบคุมคุณภาพ)',
                    'code' => 'QC',
                    'record_status' => 1,
                ],
                [
                    'id' => 7,
                    'name' => 'Transport (ฝ่ายขนส่ง)',
                    'code' => 'TP',
                    'record_status' => 1,
                ],
                [
                    'id' => 8,
                    'name' => 'Accountant (ฝ่ายบัญชี)',
                    'code' => 'AC',
                    'record_status' => 1,
                ],

                //ชุดใหม่
                [
                    'id' => 9,
                    'name' => 'Stock_viewer',
                    'code' => 'SV',
                    'record_status' => 1,
                ],
                [
                    'id' => 10,
                    'name' => 'Packaging-Supply',
                    'code' => 'PS',
                    'record_status' => 1,
                ],
                [
                    'id' => 11,
                    'name' => 'Material',
                    'code' => 'MT',
                    'record_status' => 1,
                ],
                [
                    'id' => 12,
                    'name' => 'FinishProduct',
                    'code' => 'FP',
                    'record_status' => 1,
                ],
                [
                    'id' => 13,
                    'name' => 'Qc-Material',
                    'code' => 'QCM',
                    'record_status' => 1,
                ],
                [
                    'id' => 14,
                    'name' => 'Qc-Packaging',
                    'code' => 'QCPK',
                    'record_status' => 1,
                ],
                [
                    'id' => 15,
                    'name' => 'Stock-Material',
                    'code' => 'SM',
                    'record_status' => 1,
                ],
                [
                    'id' => 16,
                    'name' => 'Stock-Packaging',
                    'code' => 'SPK',
                    'record_status' => 1,
                ],
            ]
        );
    }
}

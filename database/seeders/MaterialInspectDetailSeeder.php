<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaterialInspectDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('material_inspect_details')->delete();

        \DB::table('material_inspect_details')->insert([
                [
                    'ins_times' => "1",
                    'ins_qty' => '20',
                    'detail' => 'เป็นเนื้อเดียวกัน',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 1,
                    'audit_user_id' => 5,
                ],
                [
                    'ins_times' => "1",
                    'ins_qty' => '20',
                    'detail' => 'pH = 6',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 2,
                    'audit_user_id' => 5,
                ],
                [
                    'ins_times' => "1",
                    'ins_qty' => '20',
                    'detail' => '1',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 3,
                    'audit_user_id' => 5,
                ],
                [
                    'ins_times' => "2",
                    'ins_qty' => '20',
                    'detail' => 'ไม่เนื้อเดียวกัน',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 1,
                    'audit_user_id' => 5,
                ],
                [
                    'ins_times' => "2",
                    'ins_qty' => '20',
                    'detail' => 'pH = 7',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 2,
                    'audit_user_id' => 5,
                ],

                [
                    'ins_times' => "2",
                    'ins_qty' => '20',
                    'detail' => '0',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 3,
                    'audit_user_id' => 5,
                ],
                [
                    'ins_times' => "3",
                    'ins_qty' => '25',
                    'detail' => 'ไม่เป็นเนื้อเดียวกัน',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 1,
                    'audit_user_id' => 5,
                ],
                [
                    'ins_times' => "3",
                    'ins_qty' => '25',
                    'detail' => 'pH = 8',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 2,
                    'audit_user_id' => 5,
                ],

                [
                    'ins_times' => "3",
                    'ins_qty' => '25',
                    'detail' => '0',
                    'material_lot_id' => 1,
                    'material_inspect_id' => 3,
                    'audit_user_id' => 5,
                ],

            ]
        );
    }
}

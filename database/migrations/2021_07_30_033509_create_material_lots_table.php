<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_lots', function (Blueprint $table) {
            $table->id();
            $table->string('receive_mat_name')->comment('ชื่อวัถุดิบที่รับเข้ามาตามใบ PO');
            $table->string('lot_no_pm')->nullable();
            $table->string('lot');
            $table->string('coa')->nullable();
            $table->double('weight_grams');
            $table->double('weight_kg');
            $table->double('weight_ton');
            $table->double('weight_total');
            $table->date('mfg');
            $table->date('exp');
            $table->integer('action')->comment('1 = ยังไม่ผ่านการตรวจสอบ , 2 = อยู่ระหว่างการตรวจสอบ , 3 = ตรวจสอบแล้วแต่ยังไม่ได้ lot no pm , 4 = พร้อมใช้งาน')->default(1);
            $table->integer('quality_check')->comment('0 = ยังไม่ตรวจสอบ , 1 = ตรวจสอบแล้ว')->default(0);
            $table->integer('transport_check')->comment('0 = ยังไม่ตรวจสอบ , 1 = ตรวจสอบแล้ว')->default(0);
            $table->string('sender_vehicle_plate')->nullable();
            $table->string('transport_check_detail')->nullable();
            $table->string('transport_check_1')->nullable()->comment('ไม่มีสิ่งแปลกปลอม');
            $table->string('transport_check_2')->nullable()->comment('ความสะอาดผ่าน');
            $table->string('transport_check_3')->nullable()->comment('ไม่มีกลิ่น');
            $table->string('transport_check_4')->nullable()->comment('-');
            $table->string('transport_check_5')->nullable()->comment('-');
            $table->string('notation')->comment('หมายเหตุ')->nullable();
            $table->tinyInteger('company_id');
            $table->tinyInteger('material_id')->nullable()->comment('กำหนดหลังจากตรวจสอบเสร็จแล้ว');
            $table->tinyInteger('receive_material_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_lots');
    }
}

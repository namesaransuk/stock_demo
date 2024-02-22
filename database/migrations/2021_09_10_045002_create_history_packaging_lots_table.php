<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPackagingLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_packaging_lots', function (Blueprint $table) {
            $table->id();
            $table->string('lot_no_pm')->nullable();
            $table->string('lot');
            $table->string('coa')->nullable();
            $table->integer('qty');
            $table->date('mfg');
            $table->date('exp');
            $table->integer('action')->comment('1 = ยังไม่ผ่านการตรวจสอบ , 2 = อยู่ระหว่างการตรวจสอบ , 3 = ตรวจสอบแล้วแต่ยังไม่ได้ lot no pm , 4 = พร้อมใช้งาน')->default(1);
            $table->integer('quality_check')->comment('1 = ยังไม่ตรวจสอบ , 2 = ตรวจสอบแล้ว')->default(1);
            $table->integer('transport_check')->comment('1 = ยังไม่ตรวจสอบ , 2 = ตรวจสอบแล้ว')->default(1);
            $table->string('sender_vehicle_plate')->nullable();
            $table->string('transport_check_detail')->nullable();
            $table->string('notation')->comment('หมายเหตุ')->nullable();
            $table->integer('company_id');
            $table->integer('packaging_id');
            $table->integer('receive_packaging_id');
            $table->integer('history_receive_packaging_id');
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
        Schema::dropIfExists('history_packaging_lots');
    }
}

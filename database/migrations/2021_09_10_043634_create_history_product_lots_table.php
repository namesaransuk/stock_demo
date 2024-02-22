<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryProductLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_product_lots', function (Blueprint $table) {
            $table->id();
            $table->string('lot');
            $table->integer('qty');
            $table->date('mfg');
            $table->date('exp');
            $table->integer('action')->default(1);
            $table->integer('quality_check')->comment('0 = ยังไม่ตรวจสอบ , 1 = ตรวจสอบแล้ว')->default(0);
            $table->string('notation')->comment('หมายเหตุ')->nullable();
            $table->string('qty_check')->comment('0 = ไม่ผ่าน, 1 = ผ่าน')->nullable();
            $table->integer('company_id');
            $table->integer('product_id');
            $table->integer('receive_product_id');
            $table->integer('unit_id');
            $table->integer('history_receive_product_id');
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
        Schema::dropIfExists('history_product_lots');
    }
}

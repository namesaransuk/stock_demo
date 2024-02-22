<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_products', function (Blueprint $table) {
            $table->id();
            $table->string('paper_no');
            $table->integer('paper_status')->default(1)->comment('1 = รับเข้ารอตรวจสอบ 2 = ตรวจสอบเสร็จรอดำเนินการ 3 = เสร็จสิ้น');
            $table->integer('edit_times')->default(0);
            $table->dateTime('date');
            $table->tinyInteger('inspect_ready')->default(0)->comment("แสดงผลในหน้าตรวจสอบหรือไม่ 0 = No , 1 = Yes");
            $table->string('created_by');
            $table->string('updated_by');
            $table->integer('production_user_id')->nullable();
            $table->integer('stock_user_id')->nullable();
            $table->string('recap')->nullable()->comment('หมายเหตุ');
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
        Schema::dropIfExists('receive_products');
    }
}

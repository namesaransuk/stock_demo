<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_supplies', function (Blueprint $table) {
            $table->id();
            $table->string('paper_no');
            $table->integer('paper_status')->default(1)->comment('1 = รอดำเนินการ 2 = เสร็จสิ้น');
            $table->integer('edit_times');
            $table->integer('reject_status')->default(0)->comment('0 = ปกติ 1 = ตีกลับดีลเลอร์');
            $table->string('reject_detail')->nullable()->comment('รายละเอียดการตีกลับ');
            $table->dateTime('date');
            $table->string('created_by');
            $table->string('updated_by');
            $table->integer('stock_user_id');
            $table->integer('brand_vendor_id');
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
        Schema::dropIfExists('receive_supplies');
    }
}

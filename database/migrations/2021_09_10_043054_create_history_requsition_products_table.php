<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryRequsitionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_requsition_products', function (Blueprint $table) {
            $table->id();
            $table->string('paper_no');
            $table->integer('paper_status')->default(1)->comment('	1 = ยื่นเรื่องเบิก 2 = เบิกสำเร็จ 3 = ทำรายการไม่สำเร็จ 4 = ยื่นเรื่องคืน 5 = คืนสำเร็จ 6 = ทำรายการสำเร็จ');
            $table->integer('edit_times');
            $table->dateTime('date');
            $table->tinyInteger('ins_cut')->default(0)->comment("0 = NO , 1 = YES");
            $table->tinyInteger('ins_return')->default(0)->comment("0 = NO , 1 = YES");
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('receive_name');
            $table->string('receive_vehicle');
            $table->string('receive_house_no');
            $table->string('receive_tumbol');
            $table->string('receive_aumphur');
            $table->string('receive_province');
            $table->string('receive_postcode');
            $table->string('receive_full_addr');
            $table->string('receive_tel');
            $table->tinyInteger('transport_type')->comment("1=ส่งเอง, 2=ลูกค้ามารับ, 3=ส่งผ่านขนส่ง");
            $table->integer('requsition_product_id');
            $table->integer('transport_user_id')->nullable();
            $table->integer('audit_user_id')->nullable();
            $table->integer('qc_user_id')->nullable();
            $table->integer('stock_user_id')->nullable();
            $table->integer('vehicle_id')->nullable();
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
        Schema::dropIfExists('history_requsition_products');
    }
}

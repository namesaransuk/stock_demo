<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryRequsitionMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_requsition_materials', function (Blueprint $table) {
            $table->id();
            $table->string('paper_no');
            $table->integer('paper_status')->default(1)->comment('	1 = ยื่นเรื่องเบิก 2 = เบิกสำเร็จ 3 = ทำรายการไม่สำเร็จ 4 = ยื่นเรื่องคืน 5 = คืนสำเร็จ 6 = ทำรายการสำเร็จ');
            $table->integer('edit_times');
            $table->dateTime('date');
            $table->tinyInteger('ins_cut')->default(0)->comment("0 = NO , 1 = YES");
            $table->tinyInteger('ins_return')->default(0)->comment("0 = NO , 1 = YES");
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('product_name')->comment('ชื่อสินค้าที่จะผลิต');
            $table->integer('requsition_material_id');
            $table->integer('production_user_id');
            $table->integer('procurement_user_id');
            $table->integer('stock_user_id');
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
        Schema::dropIfExists('history_requsition_materials');
    }
}

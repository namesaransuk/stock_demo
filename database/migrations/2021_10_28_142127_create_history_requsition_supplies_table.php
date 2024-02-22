<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryRequsitionSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_requsition_supplies', function (Blueprint $table) {
            $table->id();
            $table->string('paper_no');
            $table->integer('paper_status')->default(1)->comment('1 = ยื่นเรื่องเบิก 2 = รอดำเนินการ 3 = ทำรายการสำเร็จ');
            $table->integer('edit_times');
            $table->dateTime('date');
            $table->string('detail')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->integer('stock_user_id');
            $table->string('recap')->nullable()->comment('หมายเหตุ');
            $table->integer('requsition_supply_id');
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
        Schema::dropIfExists('history_requsition_supplies');
    }
}

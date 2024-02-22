<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryReceivePackagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_receive_packagings', function (Blueprint $table) {
            $table->id();
            $table->string('paper_no');
            $table->string('po_no')->nullable();
            $table->string('po_file_name')->nullable();
            $table->integer('paper_status')->default(1)->comment('1 = ต้องดำเนินการต่อ 2 = เสร็จสิ้น');
            $table->integer('edit_times');
            $table->dateTime('date');
            $table->tinyInteger('inspect_ready')->default(0)->comment("0 = No , 1 = Yes");
            $table->string('created_by');
            $table->string('updated_by');
            $table->integer('receive_packaging_id');
            $table->integer('stock_user_id');
            $table->integer('admin_user_id')->nullable();
            $table->integer('brand_vendor_id');
            $table->integer('logistic_vendor_id');
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
        Schema::dropIfExists('history_receive_packagings');
    }
}

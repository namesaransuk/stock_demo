<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryProductCutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_product_cuts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datetime');
            $table->integer('qty');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('product_lot_id');
            $table->integer('requsition_product_id');
            $table->integer('history_requsition_product_id');
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
        Schema::dropIfExists('history_product_cuts');
    }
}

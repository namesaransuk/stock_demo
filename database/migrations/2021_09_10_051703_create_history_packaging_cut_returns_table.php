<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPackagingCutReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_packaging_cut_returns', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datetime');
            $table->integer('qty');
            $table->integer('action');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('requsition_packaging_id');
            $table->integer('history_requsition_packaging_id');
            $table->integer('packaging_lot_id');
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
        Schema::dropIfExists('history_packaging_cut_returns');
    }
}

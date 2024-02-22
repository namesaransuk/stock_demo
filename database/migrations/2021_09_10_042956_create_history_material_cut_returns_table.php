<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryMaterialCutReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_material_cut_returns', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datetime');
            $table->integer('weight');
            $table->integer('action');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('requsition_material_id');
            $table->integer('material_lot_id');
            $table->integer('history_requsition_material_id');
            $table->tinyInteger('claim_flag')->default(0);
            $table->tinyInteger('stock_accept')->default(0);
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
        Schema::dropIfExists('history_material_cut_returns');
    }
}

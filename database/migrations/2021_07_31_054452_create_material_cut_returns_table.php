<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialCutReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_cut_returns', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datetime');
            $table->integer('weight');
            $table->integer('action')->comment('1=cut , 2=return');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('requsition_material_id');
            $table->integer('material_lot_id');
            $table->tinyInteger('reserve')->default(1);
            $table->tinyInteger('inventory_approve')->default(0);
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
        Schema::dropIfExists('material_cut_returns');
    }
}

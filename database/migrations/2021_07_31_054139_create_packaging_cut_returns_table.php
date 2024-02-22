<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagingCutReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_cut_returns', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datetime');
            $table->integer('qty');
            $table->integer('action')->comment('1=cut , 2=return');
            $table->integer('created_by');
            $table->integer('updated_by');

            // new_return
            $table->integer('use_qty')->default(0);

            $table->integer('met_good')->default(0);
            $table->integer('met_waste')->default(0);
            $table->integer('met_claim')->default(0);
            $table->integer('met_destroy')->default(0);

            $table->integer('requsition_packaging_id');
            $table->integer('packaging_lot_id');
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
        Schema::dropIfExists('packaging_cut_returns');
    }
}

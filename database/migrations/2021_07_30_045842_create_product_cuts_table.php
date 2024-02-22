<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cuts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datetime');
            $table->integer('action')->comment('1=cut');
            $table->integer('qty');
            $table->integer('reserve')->default(1);
            $table->integer('inventory_approve')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('product_lot_id');
            $table->integer('requsition_product_id');
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
        Schema::dropIfExists('product_cuts');
    }
}

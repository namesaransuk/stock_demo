<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryProductInspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_product_inspects', function (Blueprint $table) {
            $table->id();
            $table->string('ins_template_name');
            $table->string('ins_topic');
            $table->string('ins_method');
            $table->integer('ins_type');
            $table->integer('sequence');
            $table->integer('product_inspect_id');
            $table->integer('inspect_template_id');
            $table->integer('product_lot_id');
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
        Schema::dropIfExists('history_product_inspects');
    }
}

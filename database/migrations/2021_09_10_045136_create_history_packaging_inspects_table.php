<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPackagingInspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_packaging_inspects', function (Blueprint $table) {
            $table->id();
            $table->string('ins_template_name');
            $table->string('ins_topic');
            $table->string('ins_method');
            $table->integer('ins_type');
            $table->integer('sequence');
            $table->integer('packaging_inspect_id');
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
        Schema::dropIfExists('history_packaging_inspects');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagingInspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_inspects', function (Blueprint $table) {
            $table->id();
            $table->string('ins_template_name');
            $table->string('ins_topic');
            $table->string('ins_type')->comment("1=details,2=results");
            $table->string('ins_method');
            $table->integer('sequence');
            $table->integer('inspect_template_id');
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
        Schema::dropIfExists('packaging_inspects');
    }
}

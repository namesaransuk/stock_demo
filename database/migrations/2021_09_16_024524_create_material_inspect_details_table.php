<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialInspectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_inspect_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ins_times');
            $table->string('ins_qty')->nullable();
            $table->string('detail');
            $table->integer('material_lot_id');
            $table->integer('material_inspect_id');
            $table->integer('audit_user_id');
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
        Schema::dropIfExists('material_inspect_details');
    }
}

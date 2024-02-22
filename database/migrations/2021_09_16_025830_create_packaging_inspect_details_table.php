<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagingInspectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_inspect_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ins_times');
            $table->string('ins_qty');
            $table->string('detail');
            $table->integer('packaging_lot_id');
            $table->integer('packaging_inspect_id');
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
        Schema::dropIfExists('packaging_inspect_details');
    }
}

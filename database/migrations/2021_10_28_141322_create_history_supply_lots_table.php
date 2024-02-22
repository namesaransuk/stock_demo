<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorySupplyLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_supply_lots', function (Blueprint $table) {
            $table->id();
            $table->string('lot');
            $table->integer('qty');
            $table->date('mfg')->nullable();
            $table->date('exp')->nullable();
            $table->string('action');
            $table->integer('company_id');
            $table->integer('receive_supply_id');
            $table->integer('supply_id');
            $table->integer('history_receive_supply_id');
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
        Schema::dropIfExists('history_supply_lots');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorySupplyCutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_supply_cuts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datetime');
            $table->integer('action')->comment('1=cut');
            $table->integer('qty');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('supply_lot_id');
            $table->integer('requsition_supply_id');
            $table->integer('history_requsition_supply_id');
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
        Schema::dropIfExists('history_supply_cuts');
    }
}

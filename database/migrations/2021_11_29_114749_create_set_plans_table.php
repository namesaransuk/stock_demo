<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_plans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_add');
            $table->string('event');
            $table->date('start');
            $table->date('end');
            $table->string('color');
            $table->string('remark')->nullable();
            $table->tinyInteger('record_status')->default(1);
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
        Schema::dropIfExists('set_plans');
    }
}

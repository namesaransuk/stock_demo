<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPackagingInspectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_packaging_inspect_details', function (Blueprint $table) {
            $table->id();
            $table->string('ins_times');
            $table->string('ins_qty');
            $table->string('detail');
            $table->integer('history_packaging_inspect_id');
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
        Schema::dropIfExists('history_packaging_inspect_details');
    }
}

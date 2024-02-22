<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->nullable();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('address_th')->nullable();
            $table->string('address_en')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('companies');
    }
}

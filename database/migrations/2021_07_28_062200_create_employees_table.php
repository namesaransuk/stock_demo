<?php

use App\Models\Prefix;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_no');
            $table->string('fname');
            $table->string('lname');
            $table->string('tel');
            $table->string('citizen_no');
            $table->tinyInteger('record_status')->default(1);
            $table->timestamps();
            $table->tinyInteger('prefix_id');
            $table->tinyInteger('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }



}

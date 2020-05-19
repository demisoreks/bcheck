<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestigatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bch_investigators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('acc_employees');
            $table->string('first_name', 50);
            $table->string('surname', 50);
            $table->string('phone1', 20);
            $table->string('phone2', 20)->nullable();
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
        Schema::dropIfExists('bch_investigators');
    }
}

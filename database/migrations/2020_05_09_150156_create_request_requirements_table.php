<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bch_request_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_service_id')->unsigned();
            $table->foreign('request_service_id')->references('id')->on('bch_request_services');
            $table->text('information')->nullable();
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
        Schema::dropIfExists('bch_request_requirements');
    }
}

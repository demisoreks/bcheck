<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bch_request_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('bch_requests');
            $table->bigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('bch_services');
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
        Schema::dropIfExists('bch_request_services');
    }
}

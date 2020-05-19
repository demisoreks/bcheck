<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bch_request_requirements', function (Blueprint $table) {
            $table->bigInteger('requirement_id')->unsigned()->after('request_service_id');
            $table->foreign('requirement_id')->references('id')->on('bch_requirements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bch_request_requirements', function (Blueprint $table) {
            //
        });
    }
}

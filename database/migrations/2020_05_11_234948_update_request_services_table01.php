<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestServicesTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bch_request_services', function (Blueprint $table) {
            $table->string('evidence_ext', 100)->nullable();
            $table->string('report_ext', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bch_request_services', function (Blueprint $table) {
            //
        });
    }
}

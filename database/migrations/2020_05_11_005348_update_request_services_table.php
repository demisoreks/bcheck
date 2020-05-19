<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bch_request_services', function (Blueprint $table) {
            $table->string('status', 100)->nullable()->after('service_id');
            $table->string('result', 100)->nullable();
            $table->text('comment')->nullable();
            $table->integer('employee_id')->unsigned()->nullable();
            $table->datetime('treated_at')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvestigatorsTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bch_investigators', function (Blueprint $table) {
            $table->string('gender', 10)->after('surname');
            $table->string('bank', 100)->nullable()->after('competencies');
            $table->string('account_number', 100)->nullable()->after('bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bch_investigators', function (Blueprint $table) {
            //
        });
    }
}

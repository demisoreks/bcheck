<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvestigatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bch_investigators', function (Blueprint $table) {
            $table->string('region', '100')->nullable()->after('phone2');
            $table->text('competencies')->nullable()->after('region');
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

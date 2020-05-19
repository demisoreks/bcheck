<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bch_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->unique('name');
            $table->text('address')->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('mobile_no', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('bch_clients');
    }
}

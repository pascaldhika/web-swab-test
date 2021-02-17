<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrasidetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasidetail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('registrasiid');
            $table->string('name');
            $table->string('address');
            $table->string('identityno');
            $table->string('birthplace');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('job');
            $table->string('country');
            $table->string('status');
            $table->string('createdby');
            $table->string('updatedby');
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
        Schema::dropIfExists('registrasidetail');
    }
}

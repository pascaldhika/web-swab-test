<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('docdate');
            $table->string('docno');
            $table->string('type');
            $table->integer('print');
            $table->string('payment');
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
        Schema::dropIfExists('registrasi');
    }
}

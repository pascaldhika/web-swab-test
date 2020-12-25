<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutonumDatatypeResetValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autonum_datatype_reset_value', function (Blueprint $table) {
            $table->string('datatype');
            $table->string('prefix');
            $table->integer('last_counter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autonum_datatype_reset_value');
    }
}

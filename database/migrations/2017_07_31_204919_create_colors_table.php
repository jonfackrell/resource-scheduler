<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('hex_code')->nullable();
        });

        Schema::create('filaments_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filament')->unsigned();
            $table->integer('color')->unsigned();
            $table->integer('department')->unsigned();
            $table->float('quantity')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colors');
        Schema::dropIfExists('filaments_colors');
    }
}

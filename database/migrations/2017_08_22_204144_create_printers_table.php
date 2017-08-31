<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->string('image');
            $table->integer('department')->unsigned();
            $table->integer('flat_fee')->default(0);
            $table->integer('per_hour')->default(0);
            $table->integer('overtime_fee')->default(0);
            $table->integer('overtime_start')->default(0);
            $table->timestamps();
        });

        Schema::create('printers_filaments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('printer')->unsigned();
            $table->integer('filament')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printers_filaments');
        Schema::dropIfExists('printers');
    }
}

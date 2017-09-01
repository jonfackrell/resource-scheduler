<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filaments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department')->unsigned();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('order_column');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('departments_filaments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department')->unsigned();
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
        Schema::dropIfExists('departments_filaments');
        Schema::dropIfExists('filaments');
    }
}

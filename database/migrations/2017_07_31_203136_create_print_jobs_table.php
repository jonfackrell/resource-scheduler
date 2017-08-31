<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('print_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patron')->unsigned();
            $table->integer('department')->unsigned();
            $table->integer('filament')->unsigned();
            $table->integer('color')->unsigned();
            $table->string('original_filename')->nullable();
            $table->string('filename')->nullable();
            $table->integer('time')->nullable();
            $table->integer('weight')->nullable();
            $table->json('options')->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->integer('cost')->default(0);
            $table->boolean('paid')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('print_jobs');
    }
}

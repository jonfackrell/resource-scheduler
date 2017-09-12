<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('department')->unsigned();
            $table->integer('notification')->unsigned()->nullable();
            $table->boolean('accept_payment')->default(0);
            $table->boolean('in_queue')->default(0);
            $table->boolean('can_delete')->default(0);
            $table->boolean('dashboard_display')->default(0);
            $table->integer('order_column');
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
        Schema::dropIfExists('statuses');
    }
}

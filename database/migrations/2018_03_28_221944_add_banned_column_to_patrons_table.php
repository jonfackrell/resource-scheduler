<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBannedColumnToPatronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patrons', function (Blueprint $table) {
            $table->boolean('banned')->default(0);
            $table->longText('banned_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patrons', function (Blueprint $table) {
            Schema::dropIfExists('banned');
            Schema::dropIfExists('banned_reason');
        });
    }
}

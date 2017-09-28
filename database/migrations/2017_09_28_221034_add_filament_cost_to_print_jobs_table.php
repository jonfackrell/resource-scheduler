<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilamentCostToPrintJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('print_jobs', function (Blueprint $table) {
            $table->float('cost_per_gram')->default(0);
            $table->string('pricing')->default('full');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('print_jobs', function (Blueprint $table) {
            $table->dropIfExists('cost_per_gram');
            $table->dropIfExists('pricing');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department');
            $table->string('code')->index();
            $table->integer('value');
            $table->integer('patron')->nullable()->unsigned()->index();
            $table->dateTime('redeemed_at')->nullable();
            $table->dateTime('expiration_at')->nullable();
            $table->timestamps();
        });

        Schema::table('print_jobs', function (Blueprint $table) {
            $table->integer('couponid')->nullable()->unsigned()->index();
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
            $table->dropColumn('couponid');
        });

        Schema::dropIfExists('coupons');
    }
}

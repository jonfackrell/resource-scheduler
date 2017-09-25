<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department')->unsigned();
            $table->string('display_name')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message')->nullable();
            $table->integer('order_column');
            $table->timestamps();
        });

        $notification                   = new \App\Models\Notification();
        $notification->department       = 1;
        $notification->display_name     = 'Print Job Approved';
        $notification->subject          = 'Print Job Approved';
        $notification->message          = 'Your print job has been approved and will be added to the queue.';
        $notification->save();

        $notification                   = new \App\Models\Notification();
        $notification->department       = 1;
        $notification->display_name     = 'Ready for Pickup';
        $notification->subject          = 'Ready for Pickup';
        $notification->message          = 'Your print job has been completed and is ready for pickup.';
        $notification->save();

        $notification                   = new \App\Models\Notification();
        $notification->department       = 1;
        $notification->display_name     = 'Print Job Rejected';
        $notification->subject          = 'Print Job Rejected';
        $notification->message          = 'Unfortunately there was a problem with you model and it cannot be printed.';
        $notification->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}

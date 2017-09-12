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
            $table->string('display_name');
            $table->string('name');
            $table->timestamps();
        });

        $notification                   = new \App\Models\Notification();
        $notification->display_name     = 'Print Job Approved';
        $notification->name             = 'PrintJobApprovedNotification';
        $notification->save();

        $notification                   = new \App\Models\Notification();
        $notification->display_name     = 'Ready for Pickup';
        $notification->name             = 'PickUpNotification';
        $notification->save();

        $notification                   = new \App\Models\Notification();
        $notification->display_name     = 'Reject Print Job';
        $notification->name             = 'PrintJobRejectionNotification';
        $notification->save();

        /*
        $notification                   = new \App\Models\Notification();
        $notification->display_name     = 'Payment Received';
        $notification->name             = 'PaymentReceivedNotification';
        $notification->save();
        */

        $notification                   = new \App\Models\Notification();
        $notification->display_name     = 'Generic Notification';
        $notification->name             = 'GenericNotification';
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

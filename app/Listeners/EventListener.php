<?php

namespace App\Listeners;

use App\Events\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Patron;
use Illuminate\Support\Facades\Log;

class EventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $patron = Patron::find($event->patron);
        switch($event->value){
            case 1:
                //nothing to do

                break;
            case 2:
                
                $patron->notify(new \App\Notifications\SendPrintJobApprovedNotification($event->id));
                break;
            case 3:
                
                $patron->notify(new \App\Notifications\SendPrintJobPrintingNotification($event->id));
                break;    
            case 4:
                
                $patron->notify(new \App\Notifications\SendPickUpNotification($event->id));
                break;    
            case 5: 
            $patron->notify(new \App\Notifications\SendDifferentFileNotification($event->id));
                break;
                    

        }
    }
}

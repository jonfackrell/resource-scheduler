<?php

namespace App\Listeners;

use App\Events\PrintJobCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrintJob implements ShouldQueue
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
     * @param  PrintJobCreated  $event
     * @return void
     */
    public function created(PrintJobCreated $event)
    {
        //
    }
}

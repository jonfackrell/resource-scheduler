<?php

namespace App\Listeners;

use App\Events\FilamentUsed;

use App\Models\FilamentColor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateFilament
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
     * @param  FilamentUsed  $event
     * @return void
     */
    public function handle(FilamentUsed $event)
    {
        $filament = FilamentColor::whereDepartment($event->printjob->department)
                        ->whereColor($event->printjob->color)
                        ->whereFilament($event->printjob->filament)->get()->first();

        $filament->quantity = $filament->quantity - $event->printjob->weight;
        $filament->save();
    }
}

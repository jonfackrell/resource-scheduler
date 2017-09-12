<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\PrintJob;

class Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $patron;
    public $id;
    public $status;
    public $value;
    public $printJob;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PrintJob $printJob, $value)
    {
        // $this->$patron = $patron;
        // $this->$id = $id;
        // $this->$status = $status;

        $this->printJob = $printJob;
        $this->value = $value;
        $this->patron = $printJob->patron;
        $this->id = $printJob->id;


    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

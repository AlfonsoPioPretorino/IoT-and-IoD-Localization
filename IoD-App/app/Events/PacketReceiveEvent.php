<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PacketReceiveEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $real_coord;
    public $id;
    public $distance;


   //public $timestamp; 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($real_coord, $id, $distance)
    {
        $this->real_coord = $real_coord;
        $this->id = $id; 
        $this->distance = $distance; 

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['packetchannel'];
    }

    public function broadcastAs()
    {
        return 'lat';
    }
    
}

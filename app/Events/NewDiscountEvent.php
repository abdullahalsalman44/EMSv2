<?php

namespace App\Events;

use Pusher\Pusher;
use App\Models\Salon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewDiscountEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
   public $discountInformations;

    public function __construct($discountInformations)
    {
        $this->discountInformations=$discountInformations;


    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
         return ['my-channel'];
    }

    public function boracastWith(){
        return [
            'discount'=>$this->discountInformations,
            'salonInfo'=>Salon::query()->find($this->discountInformations['salon_id'])
        ];
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendPushNotifications implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

   public $userId,$message,$reservationId;
    public function __construct($userId,$message,$reservationId)
    {
        $this->userId=$userId;
        $this->message=$message;
        $this->reservationId=$reservationId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->userId);
    }

    public function boracastWith(){
        return [
            'message'=>$this->message,
            'reservation_id'=>$this->reservationId
        ];
    }

}

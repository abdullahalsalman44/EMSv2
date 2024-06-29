<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewReportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $user, $salon,$report_id;
    public function __construct($user, $salon,$report_id)
    {
        $this->user = $user;
        $this->salon = $salon;
        $this->report_id=$report_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'title' => 'New report',
            'body' => $this->user . ' reported to ' . $this->salon . ' Hall',
            'report_id'=>$this->report_id,
        ];
    }
}

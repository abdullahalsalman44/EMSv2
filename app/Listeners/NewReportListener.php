<?php

namespace App\Listeners;

use Pusher\Pusher;
use App\Models\notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewReportListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $pusher = new Pusher(env('PUSHER_APP_KEY'),env('PUSHER_APP_SECRET'),env('PUSHER_APP_ID'), array('cluster' => env('PUSHER_APP_CLUSTER')));



        $pusher->trigger(
            'my-channel', // اسم القناة
            'New_Report', // اسم الحدث
            [
              $event->broadcastWith() // بيانات الطلب (اختياري)
            ]
        );

        notification::query()->create([
            'title'=>$event->broadcastWith()['title'],
            'body'=>$event->broadcastWith()['body'],
            'author'=>Auth::user()->id,
            'report_id'=>$event->report_id
        ]);
    }
}

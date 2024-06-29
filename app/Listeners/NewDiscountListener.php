<?php

namespace App\Listeners;

use Pusher\Pusher;
use App\Events\NewDiscountEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewDiscountListener
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
    public function handle(NewDiscountEvent $event): void
    {

        // require __DIR__ . '/vendor/autoload.php';

        $pusher = new Pusher(env('PUSHER_APP_KEY'),env('PUSHER_APP_SECRET'),env('PUSHER_APP_ID'), array('cluster' => env('PUSHER_APP_CLUSTER')));



        $pusher->trigger(
            'my-channel', // اسم القناة
            'NewDiscount', // اسم الحدث
            [
                'message' => 'New Discount', // بيانات الإشعار
                'Discount informations' => $event->boracastWith() // بيانات الطلب (اختياري)
            ]
        );



    }
}

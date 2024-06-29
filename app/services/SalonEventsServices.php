<?php

namespace app\Services;

use App\Http\Resources\EventsResource;
use App\Http\Resources\SalonEventResource;
use App\Models\Event;
use App\Models\Salon;
use App\Models\salon_event;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class SalonEventsServices
{

    public function getAllEvents($salon_id)
    {
        $salon = Salon::find($salon_id);
        if ($salon == null) {
            return response()->json([
                'message' => 'Salon not found'
            ], 404);
        }
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            if ($salon->admin_email != $user->email) {
                return response()->json([
                    'message' => 'You cant do this action'
                ], 401);
            }
        }
        $events = $salon->events;
        if ($events->count() == 0)
            return response()->json([
                'message' => 'This salon does not offer any events'
            ], 203);
        return  EventsResource::collection($events);
    }

    public function addEvent(int $event_id, int $salon_id)
    {
        $salon = Salon::query()->find($salon_id);
        if ($salon == null)
            return response()->json([
                'message' => 'Salon not found',
            ], 404);
        if ($salon->admin_email != Auth::user()->email)
            return response()->json([
                'message' => 'You do not have permission to add event in this salon',
            ], 401);

        if (Salon::find($salon_id) == null)
            return response()->json([
                'message' => 'Salon not found'
            ], 404);
        $salo_event = salon_event::where('salon_id', '=', $salon_id)
            ->where('event_id', '=', $event_id)
            ->get();
        $event = Event::find($event_id);
        if ($salo_event->count() == 0) {
            $salo_event = salon_event::create([
                'salon_id' => $salon_id,
                'event_id' => $event_id
            ]);

            return response()->json([
                'message' => $event->name . ' event has been successfully added to the salon',
                'salon event' => $salo_event
            ], 200);
        } else
            return response()->json([
                'message' => $event->name . ' was previously provided in this salon',
                'salon event' => $salo_event
            ], 203);
    }

    public function deleteEvent($salon_event_id)
    {
        $event = salon_event::find($salon_event_id);
        if ($event == null)
            return response()->json([
                'message' => 'This salon does not provide this event'
            ], 404);

        $salon = Salon::query()->find($event->salon_id);
        if (Auth::user()->email != $salon->admin_email) {
            return response()->json([
                'message' => 'You do not have permission to delete food in this salon'
            ], 401);
        }

        $event->delete();
        return response()->json([
            'message' => 'The event has been successfully deleted'
        ], 200);
    }
}

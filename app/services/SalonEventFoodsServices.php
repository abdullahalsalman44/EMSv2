<?php

namespace app\Services;

use App\Http\Resources\GetFoodResource;
use App\Models\Event;
use App\Models\Food;
use App\Models\Foodcategory;
use App\Models\Foodtype;
use App\Models\Salon;
use App\Models\salon_event;
use App\Models\salon_event_food;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class SalonEventFoodsServices
{

    public function addFoodInEvent($salon_id, $food_id, $salon_event_id)
    {
        $salon = Salon::query()->find($salon_id);
        if ($salon == null) {
            return response()->json([
                'message' => 'Salon not found'
            ], 404);
        }

        $user = Auth::user();
        if ($user->email != $salon->admin_email) {
            return response()->json([
                'message' => 'You do not have permission to store food in this salon'
            ], 401);
        }
        if(Food::query()->find($food_id)==null){
          return response()->json([
                    'message' => 'You do not have this food in your salon'
                ], 404);
        }
        $event = salon_event::query()->find($salon_event_id);
        if ($event == null) {
            return response()->json([
                'message' => 'You do not have this event in your salon'
            ], 404);
        }
        $foods = $event->foods;
        foreach ($foods as $food) {
            if ($food->id == $food_id) {
                return response()->json([
                    'message' => 'This food is available on this event earlier'
                ], 203);
            }
        }
        $salon = salon_event::find($salon_event_id)->salon_id;
        if ($salon_id != $salon) {
            return response()->json([
                'message' => 'This salon does not offer this event'
            ], 203);
        }
        $food = Food::query()->find($food_id);
        if ($food->salon_id != $salon_id) {
            return response()->json([
                'message' => 'This salon does not serve this food'
            ], 203);
        }
        $salon_event_food = salon_event_food::create([
            'food_id' => $food_id,
            'salon_event_id' => $salon_event_id
        ]);

        return response()->json([
            'message' => $food->name . ' has been successfully added to the ' . Event::query()->find($event->event_id)->name,
            'salon_event_food' => $salon_event_food

        ], 200);
    }

    public function getFoodThisEvents(int $salon_event_id)
    {
        $salonEvent=salon_event::query()->find($salon_event_id);
        if($salonEvent==null){
            return response()->json([
                'message'=>'This event not found in this salon'
            ],404);
        }
        $salon=Salon::query()->find($salonEvent->salon_id);
        if($salon==null){
            return response()->json([
                'message'=>'Salon not found'
            ],404);
        }

        $user=Auth::user();
        if($user->hasRole('admin')){
            if($salon->admin_email!=$user->email){
                return response()->json([
                    'message'=>'You do not have permission to get foods this salon'
                ],401);
            }
        }
        return $salonEvent->foods;
    }
}

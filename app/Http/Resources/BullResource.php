<?php

namespace App\Http\Resources;

use App\Models\DressReservation;
use App\Models\FoodReservation;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'time_of_reservation'=>new ReservationDateResource(Reservation::query()->find($this->id)->resirvationDate),
            'number_of_people'=>$this->number_of_people,
            'foods'=>FoodReservationResource::collection(FoodReservation::query()->where('reservation_id',$this->id)->get()),
            'dresses'=>DressReservationResource::collection(DressReservation::query()->where('reservation_id',$this->id)->get()),
        ];
    }
}

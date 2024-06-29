<?php

namespace App\Http\Resources;

use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationInformations extends JsonResource
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
            'salon'=>Salon::query()->find($this->salon_id)->name,
            'number_of_people'=>$this->number_of_people,
            'user'=>new UserResource(User::query()->find($this->user_id)) ,
            'reservation_time'=>new ReservationDateResource($this->resirvationDate),
            'dresser'=>DressResource::collection($this->Dresses),
            'foods'=>GetFoodResource::collection($this->foods)
        ];
    }
}

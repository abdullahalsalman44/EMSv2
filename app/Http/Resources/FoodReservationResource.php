<?php

namespace App\Http\Resources;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodReservationResource extends JsonResource
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
            'food' => Food::query()->find($this->food_id)->name,
            'number' => $this->number,
            'price' => Food::query()->find($this->food_id)->price
        ];
    }
}

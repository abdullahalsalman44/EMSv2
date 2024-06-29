<?php

namespace App\Http\Resources;

use App\Models\Province;
use App\Models\Salon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'capacity' => $this->capacity,
            'pricefortable' => $this->pricefortable,
            'Adress' =>$this->Adress,
            'start'=>Carbon::parse($this->start)->format('h:i:s A'),
            'end'=>Carbon::parse($this->end)->format('h:i:s A'),
            'image'=>ImageResource::collection($this->images)
        ];
    }
}

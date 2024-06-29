<?php

namespace App\Http\Resources;

use App\Models\Dress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DressReservationResource extends JsonResource
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
            'dress' => Dress::query()->find($this->dress_id)->dresstype,
            'number' => $this->number,
            'price' => Dress::query()->find($this->dress_id)->price
        ];
    }
}

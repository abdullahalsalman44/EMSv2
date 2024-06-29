<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateDiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'discount_value'=>$this->discount_value.' %',
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'salon_id'=>$this->salon_id
        ];
    }
}

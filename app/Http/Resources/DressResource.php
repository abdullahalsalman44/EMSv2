<?php

namespace App\Http\Resources;

use App\Models\DressSize;
use App\Models\DressType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DressResource extends JsonResource
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
                'gender'=>$this->gender,
                'dresstype'=>$this->dresstype,
                'size'=>$this->size,
                'price'=>$this->price,
                'number'=>$this->number,
                'images'=>$this->images
        ];
    }
}

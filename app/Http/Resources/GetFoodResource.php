<?php

namespace App\Http\Resources;

use App\Models\Foodcategory;
use App\Models\Foodtype;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetFoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'food_type' =>$this->foodtype,
            'food_category' =>$this->foodcategory,
            'price'=>$this->price
        ];
    }
}

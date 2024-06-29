<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationDateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'day'=>Carbon::parse($this->day)->format('Y-M-D'),
            'start'=>Carbon::parse($this->start)->format('h-i-s A'),
            'end'=>Carbon::parse($this->end)->format('h-i-s A')
        ];
    }
}

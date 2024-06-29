<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends JsonResource
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
            'name'=>Event::find($this->event_id)->name,
            'event'=>Event::query()->find($this->event_id),
            'salon'=>Salon::query()->find($this->salon_id)
        ];
    }
}

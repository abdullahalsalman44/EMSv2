<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $reservation=Reservation::query()->find($this->reservation_id);
        $salon=Salon::query()->find($reservation->salon_id);
        return
        [
            'user'=>new UserResource(User::query()->find($this->user_id)),
            'reservation_number'=>$reservation->id,
            'salon_name'=>$salon->name,
            'admin_salon_email'=>$salon->admin_email,
            'report_reson'=>$this->reson
        ];
    }
}

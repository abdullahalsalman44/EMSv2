<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingDate extends Model
{
    use HasFactory;

    protected $fillable=[
        'day',
        'start',
        'end',
        'reservation_id',
        'salon_id'
    ];

    public function reservations(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }






}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function Laravel\Prompts\table;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salon_id',
        'number_of_people',
        'salon_event_id',
        'payment_state'
    ];


    public function resirvationDate(): HasOne
    {
        return $this->hasOne(BookingDate::class);
    }


    public function Dresses(): BelongsToMany
    {
        return $this->belongsToMany(Dress::class, table: 'dress_reservations');
    }

    public function salons(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function reservationDate(): HasOne
    {
        return $this->hasOne(BookingDate::class);
    }


    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'food_reservations');
    }

    public function clients():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    ////////Scops

    public function scopeId(Builder $query,$id)
    {
        return $query->find($id);
    }
}

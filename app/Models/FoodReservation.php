<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_id',
        'number',
        'reservation_id'
    ];

    public function foods(): HasMany
    {
        return $this->hasMany(Food::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}

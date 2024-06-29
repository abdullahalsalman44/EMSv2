<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DressReservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'dress_id',
        'number',
        'reservation_id'
    ];
}

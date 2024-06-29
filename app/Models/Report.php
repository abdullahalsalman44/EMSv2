<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Report extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'salon_id',
        'reservation_id',
        'reson'
    ];

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function salons():BelongsToMany
    {
        return $this->belongsToMany(Salon::class);
    }

}

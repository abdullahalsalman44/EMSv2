<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dress extends Model
{
    use HasFactory;

    protected $fillable=[
        'gender',
        'dresstype',
        'size',
        'price',
        'number'
    ];

    public function images():HasMany{
        return $this->hasMany(DressImage::class);
    }

    public function Reservations():BelongsToMany{
        return $this->belongsToMany(Reservation::class,table:'dress_reservations');
    }


    ////scops

    public function scopeId(Builder $query,$dress_id){
        return $query->find($dress_id);
    }

    public function usersFavorateMe(){
        return $this->morphToMany(User::class,'favoratable');
    }

}

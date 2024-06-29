<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'foodtype',
        'foodcategory',
        'price',
    ];

    public function salonEvents():HasMany
    {
        return $this->hasMany(salon_event_food::class);
    }

    public function reservations():BelongsToMany{
        return $this->belongsToMany(Reservation::class,'food_reservations');
    }



    /////////Scops

    public function scopeGetUsingId(Builder $query,$food_id)
    {
       return $query->find($food_id);
    }

    public function scopeType(Builder $query,$type){
       return $query->where('foodtype',$type)->get();
    }

    public function scopeCategory(Builder $query,$category){
        return $query->where('foodcategory',$category)->get();
     }

     public function scopeCategoryAndType(Builder $query,$type,$category){
        return $query->where('foodcategory',$category)
        ->where('foodtype',$type)
        ->get();
     }
}

<?php

namespace App\Models;

use App\Models\Food;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class salon_event_food extends Model
{
    use HasFactory;

    protected $fillable=[
        'food_id',
        'salon_event_id'
    ];


        public function salonevents():BelongsToMany
        {
            return $this->belongsToMany(salon_event::class);
        }


        public function foods():BelongsToMany
        {
            return $this->belongsToMany(Food::class);
        }

}

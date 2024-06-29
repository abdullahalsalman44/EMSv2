<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function Laravel\Prompts\table;

class salon_event extends Model
{
    use HasFactory;
    protected $fillable=[
        'salon_id',
        'event_id'
    ];

    public function salons():BelongsToMany
    {
        return $this->belongsToMany(Salon::class);
    }

    public function events():BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    public function foods():BelongsToMany
    {
        return $this->belongsToMany(Food::class,table:'salon_event_foods');
        // return salon_event_food::query()->with('food')->get();
    }







}

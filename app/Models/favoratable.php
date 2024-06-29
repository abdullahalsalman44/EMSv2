<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favoratable extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'favoratable_type',
        'favoratable_id'
    ];
}

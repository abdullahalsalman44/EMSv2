<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Function_;

use function PHPUnit\Framework\returnSelf;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_value',
        'start_date',
        'end_date',
        'salon_id'
    ];

    public function salons(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    static public function activeDiscounts()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $salon = Salon::query()->where('admin_email', $user->email)->first();
            if ($salon != null) {
                $discounts = $salon->discounts;

                if ($discounts->count() == 0)

                     return 'there is no discounts in your salon';
                else
                        return $discounts;

            } else

                    return 'you dont have any salon';

        }else
        {

        $today = Carbon::now();
        $todaDyate = $today->toDateString();

        $discounts = Discount::query()
            ->whereDate('start_date', '<=', $todaDyate)
            ->whereDate('end_date', '>=', $todaDyate)->get();

        if ($discounts->count() == 0)
            return 'there is no active discounts in this date';
        else
            return  $discounts;
        }
    }

    /**Scops */
    public function scopeId(Builder $query, $discount_id)
    {
        return $query->find($discount_id);
    }
}

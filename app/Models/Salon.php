<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use PhpParser\Builder\Function_;

class Salon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'pricefortable',
        'Adress',
        'admin_email',
        'start',
        'end'
    ];




    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(salon_event::class);
    }


    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    public function usersFavorateMe()
    {
        return $this->morphToMany(User::class, 'favoratable');
    }


    public function booking(): HasMany
    {
        return $this->hasMany(BookingDate::class);
    }

    public function reports():HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function isAvailable($day, $start, $end)
    {

        $reservationDay = $this->booking()->where('day', '=', $day)->first();

        if ($reservationDay == null)
            return true;

        $reservationDate = $this->booking()
            ->where('day', '=', $day)
            ->whereBetween('start', [
                $start, Carbon::parse($end)->addMinutes(59)
            ])
            ->orWhereBetween('end', [
                Carbon::parse($start)->subMinutes(59), $end,
            ])
            ->first();

        if ($reservationDate != null) {
            $reservation = Reservation::query()->find($reservationDate->reservation_id);
            if ($reservation->payment_state == 'paid')
                return false;
            else {
                $reservation->delete();
                return true;
            }
        } else {
            return true;
        }

        // if ($reservationDate != null && Reservation::query()->find($reservationDate->reservation_id)->paymen_state== 'paid') {
        //     return false; //not available
        // } else {
        //     Reservation::query()->find($reservationDate->reservation_id)->delete();
        //     return true;
        // } //available
    }

    public function salonDiscountsAvailable()
    {
        $today = Carbon::now();
        $todayToDate = $today->toDateString();

        $discounts = $this->discounts()
            ->whereDate('start_date', '<=', $todayToDate)
            ->whereDate('end_date', '>=', $todayToDate)
            ->first();

        if ($discounts != null)
            return $discounts->discount_value;
        else
            return 'no discounts';
    }
}

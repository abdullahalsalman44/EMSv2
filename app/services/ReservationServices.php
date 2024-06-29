<?php

namespace app\services;

use App\Http\Controllers\MyFatoorahController;
use App\Models\Dress;
use App\Models\Salon;
use App\Models\BookingDate;
use App\Models\Reservation;
use App\Models\FoodReservation;
use App\Models\DressReservation;
use App\Http\Resources\BullResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReservationInformations;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\LaravelMyFatoorah\MyFatoorah;
use Illuminate\Support\Facades\Log;
use App\services\FatoorahServices;

class ReservationServices
{
    public $fatoorah;
    public function __construct(FatoorahServices $fatoorah)
    {
        $this->fatoorah = $fatoorah;
    }

    public function newReservation($salon_id, $data, $timeInformations, $dresses, $foods)
    {
        //get salon
        $salon = Salon::query()->find($salon_id);

        //get user
        $user = Auth::user();

        //create new reservation
        $reservation =  Reservation::query()->create([
            'user_id' => $user->id,
            'salon_id' => $salon_id,
            'number_of_people' => $data['number_of_people'],
            'salon_event_id' => $data['salon_event_id'],

        ]);
        $reservation->payment_state = 'not_paid';
        $reservation->save();
        //create date this reservation
        BookingDate::query()->create([
            'day' => $timeInformations['day'],
            'start' => $timeInformations['start'],
            'end' => $timeInformations['end'],
            'reservation_id' => $reservation->id,
            'salon_id' => $salon->id
        ]);
        // dd($dresses);

        //reserv thre dresses
        if ($dresses) {
            foreach ($dresses as $dress) {
                DressReservation::query()->create([
                    'dress_id' => $dress['dress_id'],
                    'number' => $dress['number'],
                    'reservation_id' => $reservation->id
                ]);
                $dressInSystem = Dress::query()->find($dress['dress_id']);
                $dressInSystem->number -= $dress['number'];
                $dressInSystem->save();
            }
        }

        // reserv thre foods
        if ($foods) {
            foreach ($foods as $food) {
                FoodReservation::query()->create([
                    'food_id' => $food['food_id'],
                    'number' => $food['number'],
                    'reservation_id' => $reservation->id,
                ]);
            }
        }

        return response()->json([
            'message' => new ReservationInformations($reservation),
            'bill' => $this->bill($reservation->id)
        ]);
    }

    public function getClientReservation()
    {
        $client = Auth::user();

        $reservations = $client->reservations;

        if ($reservations->count() <= 0)
            return response()->json([
                'message' => 'You dont have any reservations'
            ], 203);
        return response()->json([
            'reservations' => BullResource::collection($reservations)
        ], 200);
    }

    public function getALLReservations($salon_id, $request)
    {
        $salon = Salon::query()->find($salon_id);
        $reservations = [];
        $user = Auth::user();
        if ($user->hasRole('client')) {
            $reservations = [];
            $clientReservations = $user->reservations;
            foreach ($clientReservations as $clientReservation) {
                if ($clientReservation['salon_id'] == $salon_id)
                    array_push($reservations, $clientReservation);
            }
            return response()->json([
                'reservations' => BullResource::collection($reservations)
            ], 200);
        }
        if ($request->has('day')) {
            $salonReservations = $salon->reservations;

            foreach ($salonReservations as $reservation) {
                $date = $reservation->resirvationDate;
                if ($date->day == $request->day) {
                    array_push($reservations, $reservation);
                }
            }
            if ($reservations) {
                return response()->json([
                    'reservation' => new BullResource($reservation)
                ], 200);
            } else {
                return response()->json([
                    'message' => 'There is no reservations in this day'
                ], 203);
            }
        }

        $reservations = $salon->reservations;

        if ($reservations->count() <= 0) {
            return response()->json([
                'message' => 'There is no reservations'
            ], 203);
        }
        return response()->json([
            'reservation' => BullResource::collection($reservations)
        ], 200);
    }

    public function bill($reservation_id)
    {
        $dressBill = 0;
        $foodBill = 0;

        $reservation = Reservation::query()->find($reservation_id);

        if ($reservation == null) {
            return response()->json([
                'message' => 'Reservation not found'
            ], 404);
        }

        $salon = Salon::query()->find($reservation->salon_id);
        $discounts = $salon->salonDiscountsAvailable();
        if ($discounts == 'no discounts')
            $pepoleBill = $salon->pricefortable * $reservation->number_of_people;
        else
            $pepoleBill = ($salon->pricefortable * $discounts / 100) * $reservation->number_of_people;


        $dresses = $reservation->Dresses;
        foreach ($dresses as $dress) {
            $number = DressReservation::query()->where('dress_id', $dress->id)->where('reservation_id', $reservation->id)->first()->number;
            $dressBill += $dress['price'] * $number;
        }


        $foods = $reservation->foods;
        foreach ($foods as $food) {
            $number = FoodReservation::query()->where('food_id', $food->id)->where('reservation_id', $reservation_id)->first()->number;
            $foodBill += $food->price * $number;
        }

        $totalBill = $pepoleBill + $dressBill + $foodBill;

        /**
         *  My Fatoorah
         */
        $mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];


        return response()->json([
            'Bill' => new BullResource($reservation),
            'pepoleBill' => $pepoleBill,
            'dressBill' => $dressBill,
            'foodBill' => $foodBill,
            'totalBill' => $totalBill,
            'message' => 'تم إنشاء الفاتورة بنجاح',
            'payment_url' => $this->fatoorah->sendPayment($reservation_id, $totalBill, $mfConfig),
        ], 200);
    }

    public function update($reservation_id, $updateOf, $request)
    {
        $reservation = Reservation::Id($reservation_id);
        if ($reservation->count() <= 0)
            return response()->json([
                'message' => 'Reservation not found'
            ], 404);

        if ($reservation->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'You dont have permission'
            ], 203);
        }

        if ($updateOf == 'number') {
            if (Salon::query()->find($reservation->salon_id)->capacity < $request['number_of_people'])
                return response()->json([
                    'message' => 'The hall cannot accommodate this number of people'
                ], 203);

            $reservation->number_of_people = $request['number_of_people'];
            $reservation->save();
        }

        if ($updateOf == 'food') {

            $foodInReservation =  FoodReservation::query()->find($request['food_reservation_id']);

            if ($foodInReservation == null)
                return response()->json([
                    'message' => 'Food reservation not found'
                ], 404);

            $foodInReservation['food_id'] = $request['id'];
            $foodInReservation->number = $request['number'];
            $foodInReservation->save();
        }

        if ($updateOf == 'dress') {

            $dressInReservation = DressReservation::query()->find($request['dress_reservation_id']);
            if ($dressInReservation == null)
                return response()->json([
                    'message' => 'Dress reservation not found'
                ], 404);


            $dressInReservation['dress_id'] = $request['id'] ?? $dressInReservation['id'];

            if (Dress::Id($dressInReservation['dress_id'])->number < $request['number']) {
                return response()->json([
                    'message' => 'Quantity not available'
                ], 203);
            }
            $dressInReservation['number'] = $request['number'];

            $dress = Dress::Id($dressInReservation['dress_id']);
            $dress->number -= $request['number'];
            $dressInReservation->save();
            $dress->save();
        }


        return response()->json([
            'message' => 'Reservation updated successfully'
        ], 200);
    }

    public function delete($reservation_id)
    {
        $reservation = Reservation::Id($reservation_id);

        if ($reservation->count() <= 0)
            return response()->json([
                'message' => 'Reservation not found'
            ], 404);

        if ($reservation->user_id != Auth::user()->id)
            return response()->json([
                'message' => 'You dont have permission'
            ], 401);

        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ], 200);
    }
}

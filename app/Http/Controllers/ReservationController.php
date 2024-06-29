<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Salon;
use App\Models\BookingDate;
use Illuminate\Http\Request;
use App\services\ReservationServices;
use App\Http\Resources\ReservationInformations;

class ReservationController extends Controller
{
    private $reservationServices;

    public function __construct(ReservationServices $reservationServices)
    {
        $this->reservationServices = $reservationServices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($salon_id, Request $request)
    {
        return $this->reservationServices->getALLReservations($salon_id, $request);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($salon_id, ReservationRequest $request)
    {
        return $this->reservationServices->newReservation($salon_id, $request->data, $request->timeInformations, $request->dresses, $request->foods);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        return $this->reservationServices->update($id,$request->updateOf,$request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->reservationServices->delete($id);
    }

    public function getBill(Request $request)
    {
        return $this->reservationServices->bill($request->reservation_id);
    }

    public function getClientReservations(){
        return $this->reservationServices->getClientReservation();
    }
}

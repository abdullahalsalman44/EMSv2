<?php

namespace App\Http\Controllers;

use App\Models\salon_event_food;
use App\Services\SalonEventFoodsServices;
use Illuminate\Http\Request;

class SalonEventFoodsController extends Controller
{
    public $saloneventfood;
    /**
     * Display a listing of the resource.
     */

     public function __construct(SalonEventFoodsServices $saloneventfood) {
        $this->saloneventfood=$saloneventfood;
     }

    public function index(Request $request)
    {
        return $this->saloneventfood->getFoodThisEvents($request->salon_event_id);

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
    public function store(int $salon_id,Request $request)
    {
       return $this->saloneventfood->addFoodInEvent($salon_id,$request->food_id,$request->salon_event_id);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

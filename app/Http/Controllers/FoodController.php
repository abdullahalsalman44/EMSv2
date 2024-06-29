<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Services\FoodServices;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public $foodservices;

    public function __construct(FoodServices $foodservices) {
        $this->foodservices=$foodservices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->foodservices->indexFood($request);
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
    public function store(StoreFoodRequest $storefood)
    {
      return  $this->foodservices->storFood($storefood->validated());
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
    public function update( int $food_id,UpdateFoodRequest $request)
    {
       return $this->foodservices->updateFood($food_id,$request->validated());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $food_id)
    {
       return $this->foodservices->deleteFood($food_id);
    }
}

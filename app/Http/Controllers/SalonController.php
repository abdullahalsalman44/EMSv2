<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteSalonResource;
use App\Http\Requests\SalonStorRequest;
use App\Http\Requests\SalonUpdateRequest;
use App\Models\Salon;
use App\Services\SalonsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SalonController extends Controller
{
  public $salonsService;
    public function __construct(SalonsService $salonsService) {
        $this->salonsService=$salonsService;
    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
    return $this->salonsService->getSalons();
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
    public function store(SalonStorRequest $request)
    {
        return $this->salonsService->storSalon($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->salonsService->getSalon($id);
    }

    public function getsalonusingprovince(Request $request)
    {
      return $this->salonsService->getsalonusingprovince($request->province);
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
    public function update(SalonUpdateRequest $SalonUpdateRequest, $id)
    {
        return $this->salonsService->updateSalon($SalonUpdateRequest->request->all(),$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($salon_id)
    {
        return $this->salonsService->deletSalon($salon_id);
    }

    public function searchSalon(Request $request){
    //    return $this->salonsService->srearchSalon($request->salonName);
    return $this->salonsService->srearchSalon($request->name);
    }
}

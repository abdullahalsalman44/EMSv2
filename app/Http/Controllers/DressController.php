<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DressServices;
use App\Http\Requests\DressRequest;
use App\Http\Requests\DressUpdateRequest;
use App\Models\Dress;
use App\Models\DressImage;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class DressController extends Controller
{

  public  $dressServices;

  public function __construct(DressServices $dressServices) {
    $this->dressServices=$dressServices;
  }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->dressServices->getAllDresses();
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
    public function store(DressRequest $dressRequest)
    {
        return $this->dressServices->storDress($dressRequest->request->all());
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
    public function update(DressUpdateRequest $request,$id)
    {
        return $this->dressServices->updateDress($request->validated(),$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dress=Dress::query()->find($id);
        if($dress!=null){
            $dress->delete();
            return response()->json([
                'message'=>'Dress deleted successfully'
            ],200);
        }

        return response()->json([
            'message'=>'Dress not found'
        ],404);

    }
}

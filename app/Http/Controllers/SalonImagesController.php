<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Salon;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\returnSelf;

class SalonImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store($salon_id, Request $request)
    {
        $salon = Salon::query()->find($salon_id);
        if ($salon->admin_email != Auth::user()->email)
            return response()->json([
                'message' => 'You dont have permission to add image to this salon'
            ], 401);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();
            $myimage = time() . '.' . $extention;
            Storage::disk('public')->put($myimage, file_get_contents($image));
            Image::create([
                'path' => $myimage,
                'salon_id' => $salon_id
            ]);
            return response()->json([
                'message' => 'The photo has been successfully added to this salon',
                'path' => $myimage
            ], 200);
        }
        return response()->json([
            'message' => 'Image not found'
        ], 203);
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
        $image = Image::query()->find($id);
        if($image==null){
            return response()->json([
                'message'=>'Image not found'
            ],404);
        }
        $ss=Storage::disk('public')->delete($image->path);
        if($ss==true){
            $image->delete();
            return response()->json([
                'message'=>'Image deleted successfullt'
        ],200);
        }else{
            return response()->json([
                'message'=>'Something went wrong'
        ],203);
        }

    }
}

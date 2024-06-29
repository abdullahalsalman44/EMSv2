<?php

namespace App\Http\Controllers;

use App\Models\DressImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DressImageController extends Controller
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
    public function store($dress_id, Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();
            $dressImage = time() . '.' . $extention;
            Storage::disk('public')->put($dressImage, file_get_contents($image));
            DressImage::query()->create([
                'dress_id' => $dress_id,
                'path' => $dressImage
            ], 200);
            return response()->json([
                'message' => 'successfully',
                'image' => $dressImage
            ], 200);
        } else {
            return response()->json([
                'message' => 'Image not found'
            ], 404);
        }
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
        $image = DressImage::query()->find($id);
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

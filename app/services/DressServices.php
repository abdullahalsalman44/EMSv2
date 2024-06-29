<?php

namespace app\Services;

use App\Http\Requests\DressRequest;
use App\Http\Resources\DressResource;
use App\Models\Dress;

class DressServices
{

    public function storDress($dress)
    {
        $Dress = Dress::create($dress);
        return response()->json([
            'message' => 'The clothes stored successfully',
            'dress' => $Dress
        ], 200);
    }

    public function getAllDresses()
    {
        $dresses = Dress::all();
        if ($dresses->count() <= 0) {
            return response()->json([
                'message' => 'There are no clothes in order currentrly',
            ], 203);
        }


        return response()->json([
            'Clothes' => DressResource::collection($dresses)
        ], 200);
    }

    public function updateDress($data, $id)
    {
        $dress = Dress::query()->find($id);

        if ($dress == null) {
            return response()->json([
                'message' => 'No clothes found'
            ], 404);
        }

        $dress->update([
            $dress['gender'] = $data['gender'] ?? $dress['gender'],
            $dress['dresstype'] = $data['dresstype'] ?? $dress['dresstype'],
            $dress['size'] = $data['size'] ?? $dress['size'],
            $dress['price'] = $data['price'] ?? $dress['price'],
            $dress['number'] = $data['number'] ?? $dress['number']
        ]);

        $dress->save();

        return response()->json([
            'message' => 'The clothes have been updated successfully',
            'clothes' => $dress
        ], 200);
    }
}

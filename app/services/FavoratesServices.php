<?php

namespace app\services;

use App\Http\Resources\DressResource;
use App\Http\Resources\SalonResource;
use App\Models\Dress;
use App\Models\favoratable;
use App\Models\Salon;
use Illuminate\Support\Facades\Auth;

class FavoratesServices
{
    public function getSalonFavorates()
    {
        $user = Auth::user();
        $favorates = $user->salonsFavorates;
        if ($favorates->count() <= 0)
            return response()->json([
                'message' => 'There are no salon favorates'
            ],203);
        return response()->json([
            'favorates' => SalonResource::collection($favorates)
        ],200);
    }

    public function getDressFavorates()
    {
        $user = Auth::user();
        $favorates = $user->dressFavorates;
        if ($favorates->count() <= 0)
            return response()->json([
                'message' => 'There are no dress favorates'
            ],203);
        return response()->json([
            'favorates' => DressResource::collection($favorates)
        ],200);
    }

    public function addToFavorate($data)
    {
        $user = Auth::user();
        if (isset($data['salon_id'])) {
            $salon = Salon::query()->find($data['salon_id']);
            $salon->usersFavorateMe()->attach($user);
            return response()->json([
                'message' => 'Salon add to favorate successfully'
            ],200);
        } else
        if (isset($data['dress_id'])) {
            $dress = Dress::query()->find($data['dress_id']);
            $dress->usersFavorateMe()->attach($user);
            return response()->json([
                'message' => 'dress add to favorate successfully'
            ],200);
        }
    }

    public function deleteFromFavorate($data)
    {
        $user = Auth::user();
        if (isset($data['salon_id'])) {
            favoratable::query()->where('user_id', $user->id)
                ->where('favoratable_type', 'App\Models\Salon')
                ->where('favoratable_id', $data['salon_id'])
                ->delete();


            return response()->json([
                'message' => 'Salon deleted frome favorate successfully'
            ],200);
        } else
        if (isset($data['dress_id'])) {
            favoratable::query()->where('user_id', $user->id)
                ->where('favoratable_type', 'App\Models\Dress')
                ->where('favoratable_id', $data['dress_id'])
                ->delete();


            return response()->json([
                'message' => 'Dress deleted frome favorate successfully'
            ],200);
        }

    }
}

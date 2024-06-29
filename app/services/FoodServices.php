<?php

namespace app\Services;

use App\Models\Food;
use App\Models\Salon;
use App\Models\Foodtype;
use App\Models\Foodcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreFoodRequest;
use App\Http\Resources\GetFoodResource;

class FoodServices
{
    public function indexFood($request)
    {
        if ($request->has('type') && $request->has('category'))
            $food = GetFoodResource::collection(Food::CategoryAndType($request->type, $request->category));
        else  if ($request->has('type'))
            $food = GetFoodResource::collection(Food::Type($request->type));
        else if ($request->has('category'))
            $food = GetFoodResource::collection(Food::Category($request->category));

        else  $food = GetFoodResource::collection(Food::all());

        if ($food->count() <= 0)
            return response()->json([
                'message' => 'There is no foods'
            ], 203);

        return response()->json([
            'foods' => $food
        ], 200);
    }

    public function storFood($food)
    {
        $food =  Food::query()->create($food);
        return response()->json([
            'message' => 'Food stored successfully',
            'food' => $food
        ], 200);
    }

    public function updateFood($food_id, $request)
    {
        $food = Food::GetUsingId($food_id);
        if ($food->count() <= 0)
            return response()->json([
                'message' => 'Food not found'
            ], 404);

        $food->name = $request['name'] ?? $food['name'];
        $food->foodtype = $request['foodtype'] ?? $food['foodtype'];
        $food->foodcategory = $request['foodcategory'] ?? $food['foodcategory'];
        $food->price = $request['price'] ?? $food['price'];
        $food->save();

        return response()->json([
            'message' => 'Food updated successfully',
            'food' => $food
        ], 200);
    }

    public function deleteFood($food_id)
    {
        $food = Food::GetUsingId($food_id);

        if ($food->count() <= 0)
            return response()->json([
                'message' => 'Food not found'
            ], 404);

        $food->delete();
        return response()->json([
            'message' => 'The food has been successfully removed from the menu'
        ], 200);
    }
}

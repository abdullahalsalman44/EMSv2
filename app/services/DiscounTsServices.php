<?php

namespace app\services;

use App\Events\NewDiscountEvent;
use App\Http\Resources\CreateDiscountResource;
use App\Models\Discount;
use App\Models\Salon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DiscountsServices
{

    public function newDiscount($discountInfo)
    {
        $user = Auth::user();

        $salon = Salon::query()->where('admin_email', '=', $user->email)->first();

        $discount = Discount::query()
            ->create([
                'discount_value' => $discountInfo['discount_value'],
                'start_date' => $discountInfo['start_date'],
                'end_date' => $discountInfo['end_date'],
                'salon_id' => $salon->id
            ]);


        $discount->salon_id = $salon->id;
        $discount->save();

        event(new NewDiscountEvent($discount));

        return response()->json([
            'message' => 'Discount created successfully',
            'discount' => new CreateDiscountResource($discount)
        ], 200);
    }

    public function showDiscounts(){
        $discounts=Discount::activeDiscounts();
        return response()->json([
            'discounts'=>$discounts
        ]);

    }

    public function deleteDiscount($discount_id)
    {
        $user = Auth::user();
        $discount = Discount::Id($discount_id);
        $salon = Salon::query()->find($discount->salon_id);
        if ($salon->admin_email != $user->email)
            return response()->json([
                'message' => 'You dont have permission'
            ], 401);

        if ($discount != null) {
            $discount->delete();
            return response()->json([
                'message' => 'Discount deleted successfully'
            ], 200);
        }
        return response()->json([
            'message' => 'Discount not found'
        ], 404);
    }

    public function updateDiscount($data, $discount_id)
    {
        $discount = Discount::Id($discount_id);
        if ($discount != null) {
            $discount['discount_value'] = $data['discount_value'] ?? $discount['discount_value'];
            $discount['start_date'] = $data['start_date'] ?? $discount['start_date'];
            $discount['end_date'] = $data['end_date'] ?? $discount['end_date'];
            $discount->save();

            return response()->json([
                'message' => 'Discount updated succeffuly',
                'discount' => $discount
            ], 200);
        }

        return response()->json([
            'message' => 'Discount not fount'
        ], 404);
    }
}

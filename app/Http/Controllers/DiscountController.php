<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountsRequest;
use App\services\DiscountsServices;
use App\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    public $discountServices;

    public function __construct(DiscountsServices $discountServices)
    {
        $this->discountServices = $discountServices;
    }

    public function addDiscount(DiscountsRequest $discount)
    {
        return $this->discountServices->newDiscount($discount->validated());
    }

    public function showDiscounts()
    {
        return $this->discountServices->showDiscounts();
    }

    public function updateDiscount(UpdateDiscountRequest $discount, $discount_id)
    {
        return $this->discountServices->updateDiscount($discount->validated(), $discount_id);
    }

    public function deleteDiscount($discount_id)
    {
        return $this->discountServices->deleteDiscount($discount_id);
    }
}

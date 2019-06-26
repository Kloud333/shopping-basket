<?php

namespace App\Services;

use App\Services\Discount\Discount;
use App\Services\Discount\TotalFixedDiscount;
use App\Services\Discount\SecondProductDiscount;

class Cart
{
    /**
     * @param $cartProducts
     * @param $customerId
     * @return float
     */
    public function calculateTotal($cartProducts, $customerId)
    {
        $discount = $this->getUserDiscounts($cartProducts, $customerId);

        return $discount->calculate($cartProducts, 0);
    }

    /**
     * @param $cartProducts
     * @param $customerId
     * @return TotalFixedDiscount|SecondProductDiscount|Discount
     */
    protected function getUserDiscounts($cartProducts, $customerId)
    {
        $discount = new Discount();

        if (!empty($cartProducts)) {
            $discount = new SecondProductDiscount();
        }

        if (reset($cartProducts)['quantity'] >= 2) {
            $totalFixedDiscount = new TotalFixedDiscount(500, 10);

            if (isset($discount)) {
                $discount->setNext($totalFixedDiscount);
            } else {
                $discount = $totalFixedDiscount;
            }
        }

        return $discount;
    }

    protected function getAvailableUserDiscounts()
    {
        //TODO Implement the available discounts for the user
    }
}
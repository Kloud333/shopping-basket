<?php

namespace App\Services;

use App\Services\Discount\Discount;
use App\Services\Discount\LoyaltyCardDiscount;
use App\Services\Discount\TotalFixedDiscount;
use App\Services\Discount\SecondProductDiscount;

class Cart
{
    /**
     * @param $cartProducts
     * @param $customerId
     * @param $customerDiscounts
     * @return float
     */
    public function calculateTotal($cartProducts, $customerId, $customerDiscounts)
    {
        $discount = $this->getUserDiscounts($cartProducts, $customerId, $customerDiscounts);

        return $discount->calculate($cartProducts, 0);
    }

    /**
     * @param $cartProducts
     * @param $customerId
     * @param $customerDiscounts
     * @return TotalFixedDiscount|SecondProductDiscount|Discount
     */
    protected function getUserDiscounts($cartProducts, $customerId, $customerDiscounts)
    {
        $userDiscounts = $this->getAvailableUserDiscounts($customerDiscounts);

        $discount = new Discount();

        if (in_array('second-product', $userDiscounts)) {
            $discount = new SecondProductDiscount();
        }

        if (in_array('fixed-total', $userDiscounts)) {
            $totalFixedDiscount = new TotalFixedDiscount(500, 10);

            if (isset($discount)) {
                $discount->setNext($totalFixedDiscount);
            } else {
                $discount = $totalFixedDiscount;
            }
        }

        if (in_array('loyalty-card', $userDiscounts)) {
            $LoyaltyCardDiscount = new LoyaltyCardDiscount(10);

            if (isset($discount)) {
                $discount->setNext($LoyaltyCardDiscount);
            } else {
                $discount = $LoyaltyCardDiscount;
            }
        }

        return $discount;
    }

    /**
     * @param array $customerDiscounts
     * @return array
     */
    protected function getAvailableUserDiscounts(array $customerDiscounts)
    {
        $discounts = [];

        foreach ($customerDiscounts as $customerDiscount) {
            $discounts[] = $customerDiscount['discount'];
        }

        return $discounts;
    }
}
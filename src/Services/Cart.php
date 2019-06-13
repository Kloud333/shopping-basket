<?php

namespace App\Services;

use App\Services\Discount\PercentOfTotal;
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
     * @param $customerId
     * @return PercentOfTotal|SecondProductDiscount|null
     */
    protected function getUserDiscounts($cartProducts, $customerId)
    {
        $discount = null;

        if (!empty($cartProducts)) {
            $discount = new SecondProductDiscount();
        }

        if (reset($cartProducts)['quantity'] >= 2) {
            $percentOfTotal = new PercentOfTotal(500,10);

            if (isset($discount)) {
                $discount->setNext($percentOfTotal);
            } else {
                $discount = $percentOfTotal;
            }
        }

        return $discount;
    }
}
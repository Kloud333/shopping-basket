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
        $discount = $this->getUserDiscounts($customerId);

        return $discount->calculate($cartProducts, 0);
    }

    /**
     * @param $customerId
     * @return PercentOfTotal|SecondProductDiscount|null
     */
    protected function getUserDiscounts($customerId)
    {
        $discount = null;

        if (true) {
            //TODO: add check if discount applicable
            $discount = new SecondProductDiscount();
        }

        if (true) {
            //TODO: add check if discount applicable

            $percentOfTotal = new PercentOfTotal();

            if ($discount) {
                $discount->setNext($percentOfTotal);
            } else {
                $discount = $percentOfTotal;
            }
        }

        return $discount;
    }
}
<?php

namespace App\Services\Discount;

class PercentOfTotal extends AbstractDiscount
{
    /**
     * @param array $cart
     * @param $total
     */
    public function calculate(array $cart, $total)
    {
//        if ($total > 500) {
//            $total -= $total * 0.1;
//        }

        parent::calculateDiscount($cart, $total);
    }
}
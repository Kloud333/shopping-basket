<?php

namespace App\Services\Discount;

class PercentOfTotal extends AbstractDiscount
{
    /**
     * @param array $cart
     * @param $total
     * @return float
     */
    public function calculate(array $cart, $total)
    {
        if ($total > 500) {
            $total -= 10;
        }

        return parent::calculateDiscount($cart, $total);
    }
}
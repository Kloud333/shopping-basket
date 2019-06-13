<?php

namespace App\Services\Discount;

class SecondProductDiscount extends Discount
{
    /**
     * @param array $cart
     * @param $total
     * @return float
     */
    public function calculate(array $cart, $total)
    {
        $cart = reset($cart);
        $quantity = $cart['quantity'] - 1;

        if ($cart['quantity'] > 1 && $cart['quantity'] % 2 == 0) {
            $quantity -= 2;
        }

        $total = ($cart['price'] * $quantity) / 2 + $cart['price'];

        return parent::calculateDiscount($cart, $total);
    }
}
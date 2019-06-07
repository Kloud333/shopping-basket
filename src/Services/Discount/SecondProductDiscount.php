<?php

namespace App\Services\Discount;

class SecondProductDiscount extends AbstractDiscount
{
    /**
     * @param array $cart
     * @param $total
     */
    public function calculate(array $cart, $total)
    {
//        $cart = reset($cart);
//        $quantity = $cart['quantity'] - 1;
//
//        if ($cart['quantity'] > 1 && $cart['quantity'] % 2 == 0) {
//            $quantity -= 2;
//        }
//
//        $total = ($cart['price'] * $quantity) / 2 + $cart['price'];

        parent::calculateDiscount($cart, $total);
    }
}
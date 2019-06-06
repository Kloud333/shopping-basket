<?php

namespace App\Services\discount;

class SecondProductDiscount implements Discount
{

    public function calculate(array $cart)
    {
        $cart = reset($cart);
        $quantity = $cart['quantity'] - 1;

        if ($cart['quantity'] > 1 && $cart['quantity'] % 2 == 0) {
            $quantity -= 2;
        }

        $total = ($cart['price'] * $quantity) / 2 + $cart['price'];

        return $total;
    }
}
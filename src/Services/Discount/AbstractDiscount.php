<?php

namespace App\Services\Discount;

abstract class AbstractDiscount
{
    /**
     * @var AbstractDiscount
     */
    protected $next;

    /**
     * @param $discount
     */
    public function setNext($discount)
    {
        $this->next = $discount;
    }

    /**
     * @param $cart
     * @param int $total
     * @return float
     */
    public function calculateDiscount($cart, $total = 0)
    {
        if ($this->next) {
            return $this->next->calculate($cart, $total);
        } else {
            return $total;
        }
    }
}
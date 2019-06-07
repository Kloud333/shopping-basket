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
     * @return int
     */
    public function calculateDiscount($cart, $total = 0)
    {
        if ($this->next) {
            $this->next->calculateDiscount($cart, $total);
        } else {
            return $total;
        }
    }
}
<?php

namespace App\Services\Discount;

class Discount
{
    /**
     * @var Discount
     */
    protected $next;

    /**
     * @param $discount
     */
    public function setNext($discount)
    {
        if (!$this->next) {
            $this->next = $discount;
        } else {
            $this->next->setNext($discount);
        }
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
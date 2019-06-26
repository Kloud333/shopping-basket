<?php

namespace App\Services\Discount;

class LoyaltyCardDiscount extends Discount
{
    /**
     * @var int
     */
    protected $percentOfTotal;

    /**
     * LoyaltyCardDiscount constructor.
     * @param $percentOfTotal
     */
    public function __construct($percentOfTotal)
    {
        $this->percentOfTotal = $percentOfTotal;
    }

    /**
     * @param array $cart
     * @param $total
     * @return float
     */
    public function calculate(array $cart, $total)
    {
        $total = ($total * $this->percentOfTotal) / 100;

        return parent::calculateDiscount($cart, $total);
    }
}
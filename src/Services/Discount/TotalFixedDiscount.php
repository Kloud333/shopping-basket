<?php

namespace App\Services\Discount;

class TotalFixedDiscount extends Discount
{
    /**
     * @var int
     */
    protected $fixedDiscountLimit;

    /**
     * @var int
     */
    protected $fixedDiscount;

    /**
     * PercentOfTotal constructor.
     * @param $fixedDiscountLimit
     * @param $fixedDiscount
     */
    public function __construct($fixedDiscountLimit, $fixedDiscount)
    {
        $this->fixedDiscountLimit = $fixedDiscountLimit;
        $this->fixedDiscount = $fixedDiscount;
    }


    /**
     * @param array $cart
     * @param $total
     * @return float
     */
    public function calculate(array $cart, $total)
    {
        if ($total > $this->fixedDiscountLimit) {
            $total -= $this->fixedDiscount;
        }

        return parent::calculateDiscount($cart, $total);
    }
}
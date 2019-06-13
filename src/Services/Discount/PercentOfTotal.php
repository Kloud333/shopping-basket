<?php

namespace App\Services\Discount;

class PercentOfTotal extends Discount
{
    /**
     * @var int
     */
    protected $fixed_discount_limit;

    /**
     * @var int
     */
    protected $fixed_discount;

    /**
     * PercentOfTotal constructor.
     * @param $fixed_discount_limit
     * @param $fixed_discount
     */
    public function __construct($fixed_discount_limit, $fixed_discount)
    {
        $this->fixed_discount_limit = $fixed_discount_limit;
        $this->fixed_discount = $fixed_discount;
    }


    /**
     * @param array $cart
     * @param $total
     * @return float
     */
    public function calculate(array $cart, $total)
    {
        if ($total > $this->fixed_discount_limit) {
            $total -= $this->fixed_discount;
        }

        return parent::calculateDiscount($cart, $total);
    }
}
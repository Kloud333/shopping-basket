<?php

namespace App\Services\discount;

interface Discount
{
    public function calculate(array $cart);
}
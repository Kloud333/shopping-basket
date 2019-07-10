<?php

namespace App\DataFixtures;

use App\Entity\CustomerDiscount;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerDiscountFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $discounts = ['loyalty-card', 'second-product', 'fixed-total'];

        $this->createManyWithCustomData(CustomerDiscount::class, $discounts, function (CustomerDiscount $customerDiscount, $discount) {
            $customerDiscount->setCustomer(1)
                ->setDiscount($discount);
        });

        $manager->flush();
    }
}

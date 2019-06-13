<?php

namespace App\DataFixtures;

use App\Entity\CustomerDiscount;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerDiscountFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(CustomerDiscount::class, 1, function (CustomerDiscount $customerDiscount, $count) {
            $customerDiscount->setCustomer(1)
                ->setDiscount('loyalty cards');
        });

        $manager->flush();
    }
}

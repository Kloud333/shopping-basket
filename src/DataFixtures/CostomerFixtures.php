<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Common\Persistence\ObjectManager;

class CostomerFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Customer::class, 1, function (Customer $customer, $count) {
            $customer->setName('Volodymyr')
                ->setEmail('klekotvr@gmail.com')
                ->setPassword('1234');
        });

        $manager->flush();
    }
}

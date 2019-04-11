<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Customer::class, 1, function (Customer $customer, $count) {
            $customer->setName('Volodymyr')
                ->setEmail('klekotvr@gmail.com')
                ->setPassword('1234');
        });

        $this->createMany(Product::class, 10, function (Product $product, $count) {
            $product->setName($this->faker->word)
                ->setDescription($this->faker->sentence(4))
                ->setPrice($this->faker->randomNumber(3))
                ->setStock($this->faker->randomNumber(2));
        });

        $manager->flush();
    }
}

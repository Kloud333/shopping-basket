<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
         $product = new Product();
         $product->setName('one')->setDescription('ddadsas')->setPrice(150)->setStock(150);

        $manager->persist($product);
        $manager->flush();
    }

}

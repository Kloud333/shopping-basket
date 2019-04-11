<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixture
{

    public function loadData(ObjectManager $manager)
    {

        $this->createMany(Product::class, 10, function(Product $product, $count) {

            $product->setName($this->faker->word)
                    ->setDescription($this->faker->sentence(4))
                    ->setPrice($this->faker->randomNumber(3))
                    ->setStock($this->faker->randomNumber(2));
        });

        $manager->flush();
    }


//    public function loadData(ObjectManager $manager)
//    {
//        $this->createMany(Article::class, 10, function(Article $article, $count) {
//            $article->setTitle($this->faker->randomElement(self::$articleTitles))
//                ->setContent('alapeno bacon');
//
//            // publish most articles
//            if ($this->faker->boolean(70)) {
//                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
//            }
//
//            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
//                ->setHeartCount($this->faker->numberBetween(5, 100))
//                ->setImageFilename($this->faker->randomElement(self::$articleImages))
//            ;
//        });
//
//        $manager->flush();
//    }

}

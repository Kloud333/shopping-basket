<?php

namespace App\Repository;

use App\Entity\OrderProduct;
use App\Entity\Orders;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OrderProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduct[]    findAll()
 * @method OrderProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderProduct::class);
    }

    /**
     * @param $order
     * @param $cart
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     * @throws \Doctrine\ORM\ORMException
     */
    public function createOrderProduct($order, $cart)
    {
        $em = $this->getEntityManager();
        $orderProduct = new OrderProduct();

        $lastCartId = $order->getId();
        $order = $em->getReference(Orders::class, $lastCartId);
        $orderProduct->setOrder($order);

        $productId = reset($cart)['id'];
        $product = $em->getReference(Product::class, $productId);
        $orderProduct->setProduct($product);

        $orderProduct->setQuantity(reset($cart)['quantity']);

        return $orderProduct;
    }

    // /**
    //  * @return OrderProduct[] Returns an array of OrderProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderProduct
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

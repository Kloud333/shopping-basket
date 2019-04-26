<?php

namespace App\Repository;

use App\Entity\CartProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CartProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartProduct[]    findAll()
 * @method CartProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CartProduct::class);
    }

    /**
     * @param int $customerId
     * @return array
     */
    public function getCart(int $customerId)
    {
        $qb = $this->createQueryBuilder('cart_product')
            ->select('product.id', 'product.name', 'product.price', 'cart_product.quantity')
            ->addSelect('customer.name AS customer_name')
            ->innerJoin('cart_product.product', 'product', 'Join:WITH')
            ->innerJoin('cart_product.cart', 'cart')
            ->innerJoin('cart.customer', 'customer')
            ->where('customer.id = :id')
            ->setParameter('id', $customerId);

        $query = $qb->getQuery();
//        var_dump($query->getSQL()); die;

        return $query->execute();
    }

    // /**
    //  * @return CartProduct[] Returns an array of CartProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartProduct
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

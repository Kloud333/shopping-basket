<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /**
     * @param $userId
     * @return Cart|\Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository|mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findOneOrCreateCart($userId)
    {
        $em = $this->getEntityManager();
        $cart = $em->getRepository(Cart::class);

        $cartFind = $cart->findBy(array('customer' => $userId));

        if (!$cartFind) {
            $cart = new Cart();
            $customer_id = $userId;
            $customer = $em->getReference(Customer::class, $customer_id);
            $cart->setCustomer($customer);
            $em->persist($cart);
            $em->flush();

            return $cart;
        }

        return reset($cartFind);
    }

    /**
     * @param $customerId
     * @return mixed
     */
    public function clearCart($customerId)
    {
        $qb = $this->createQueryBuilder('c')
            ->delete()
            ->where('c.customer = :customerId')
            ->setParameter('customerId', $customerId);

        $query = $qb->getQuery();
//        var_dump($query->getSQL()); die;

        return $query->execute();
    }

// /**
//  * @return Cart[] Returns an array of Cart objects
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
    public function findOneBySomeField($value): ?Cart
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

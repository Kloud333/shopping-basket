<?php

namespace App\Repository;

use App\Entity\CustomerDiscount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CustomerDiscount|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerDiscount|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerDiscount[]    findAll()
 * @method CustomerDiscount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerDiscountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CustomerDiscount::class);
    }

    // /**
    //  * @return CustomerDiscount[] Returns an array of CustomerDiscount objects
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
    public function findOneBySomeField($value): ?CustomerDiscount
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

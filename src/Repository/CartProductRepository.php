<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
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


    /**
     * @param array $cart
     * @return float|int
     */
    public function getTotal(array $cart)
    {
        $cart = reset($cart);
        $quantity = $cart['quantity'] - 1;

        if ($cart['quantity'] > 1 && $cart['quantity'] % 2 == 0) {
            $quantity -= 2;
        }

        $total = ($cart['price'] * $quantity) / 2 + $cart['price'];

        if ($total > 500) {
            $total -= $total * 0.1;
        }

        return $total;
    }


    /**
     * @param $cart
     * @param $productId
     * @return CartProduct|\Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository|mixed
     * @throws \Doctrine\ORM\ORMException
     */
    public function findOneOrCreateCartProduct($cart, $productId)
    {
        $em = $this->getEntityManager();
        $cartProduct = $em->getRepository(CartProduct::class);

        $cartFind = $cartProduct->findBy(array('cart' => $cart->getId()));

        if (!$cartFind) {
            $cartProduct = new CartProduct();

            $lastCartId = $cart->getId();
            $cart = $em->getReference(Cart::class, $lastCartId);
            $cartProduct->setCart($cart);

            $product = $em->getReference(Product::class, $productId);
            $cartProduct->setProduct($product);

            return $cartProduct;
        }

        return reset($cartFind);
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

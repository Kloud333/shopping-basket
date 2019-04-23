<?php

namespace App\Controller\Api;

use App\Entity\Cart;
use App\Entity\CartProduct;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Cart Test controller.
 */
class CartController extends AbstractFOSRestController
{

    /**
     *
     * @Rest\Get("/cart/{customerId}")
     * @param int $customerId
     * @return Response
     */
    public function getAllCart(int $customerId)
    {
        $repository = $this->getDoctrine()->getRepository(CartProduct::class);

        $cart = $repository->getCart($customerId);

//        if (!$cart) {
//            throw $this->createNotFoundException('Orders no found for customer - ' . $customerId);
//        }
//
        $serializer = $this->container->get('serializer');
        $response = $serializer->serialize($cart, 'json');

        return new Response($response, 200);
    }

    /**
     *
     * @Rest\Post("/cart")
     *
     * @param Request $request
     * @return Response
     */
    public function addToCart(Request $request)
    {
        // @TODO: Update inserting objects


        $body = $request->getContent();
        $data = json_decode($body, true);

        $em = $this->getDoctrine()->getManager();


        $cart = new Cart();
        $cart->setCustomer($data['customer_id']);
        $em->persist($cart);
        $em->flush();

        $lastCartId = $cart->getId();

        $cartProduct = new CartProduct();
        $cartProduct->setCart($lastCartId);
        $cartProduct->setProduct($data['product_id']);

        $p_id = $data['product_id'];
        $itemType = $em->getReference('...\Product', $p_id);
        $cartProduct->setProduct($itemType);

        $cartProduct->setQuantity($data['quantity']);
        $em->persist($cartProduct);
        $em->flush();

        return new Response('Added.', 200);
    }
}

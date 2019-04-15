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
     * @Rest\Get("/cart")
     */
    public function getCart()
    {
        return new Response(json_encode(['cart' => '']));
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
        $body = $request->getContent();
        $data = json_decode($body,true);

        $em = $this->getDoctrine()->getManager();


        $cart = new Cart();
        $cart->setCustomerId($data['customer_id']);
        $em->persist($cart);
        $em->flush();

        $lastCartId = $cart->getId();

        $cartProduct = new CartProduct();
        $cartProduct->setCartId($lastCartId);
        $cartProduct->setProductId($data['product_id']);
        $cartProduct->setQuantity($data['quantity']);
        $em->persist($cartProduct);
        $em->flush();

//        var_dump($data);

        return new Response('It worked!');
    }
}

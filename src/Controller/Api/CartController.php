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
class APICartController extends AbstractFOSRestController
{
    /**
     *
     * @Rest\Post("/cart")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
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

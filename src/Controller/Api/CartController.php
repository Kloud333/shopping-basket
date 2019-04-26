<?php

namespace App\Controller\Api;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Customer;
use App\Entity\Product;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

        if (!$cart) {
            throw $this->createNotFoundException('Orders not found for customer');
        }

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
        $body = $request->getContent();
        $data = json_decode($body, true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('Message', null, 400);
        }

        $em = $this->getDoctrine()->getManager();

        $cart = new Cart();
        $customer_id = $data['customer_id'];
        $customer = $em->getReference(Customer::class, $customer_id);
        $cart->setCustomer($customer);
        $em->persist($cart);
        $em->flush();

        $cartProduct = new CartProduct();

        $lastCartId = $cart->getId();
        $cart = $em->getReference(Cart::class, $lastCartId);
        $cartProduct->setCart($cart);

        $product_id = $data['product_id'];
        $product = $em->getReference(Product::class, $product_id);
        $cartProduct->setProduct($product);

        $cartProduct->setQuantity($data['quantity']);
        $em->persist($cartProduct);
        $em->flush();

        return new Response('Product successfully added to cart', 200);
    }

    /**
     *
     * @Rest\Get("/clean/cart/{customerId}")
     * @param int $customerId
     * @return Response
     */
    public function clearCart(int $customerId)
    {
        $repository = $this->getDoctrine()->getRepository(Cart::class);

        $cart = $repository->clearCart($customerId);

        return new Response('Product successfully deleted from cart', 200);
    }
}

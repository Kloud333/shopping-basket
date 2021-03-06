<?php

namespace App\Controller\Api;

use App\Entity\Cart;
//use App\Services\Cart;
use App\Entity\CartProduct;
use App\Entity\OrderProduct;
use App\Entity\Orders;
use App\Entity\CustomerDiscount;
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
     * @Rest\Get("/cart/{customerId}")
     *
     * @param int $customerId
     * @return Response
     */
    public function getCart(int $customerId)
    {
        $cartProductRepository = $this->getDoctrine()->getRepository(CartProduct::class);
        $customerDiscountRepository = $this->getDoctrine()->getRepository(CustomerDiscount::class);

        $cartProducts = $cartProductRepository->getCartProduct($customerId);
        $customerDiscounts = $customerDiscountRepository->getAllCustomerDiscounts($customerId);

        if (!$cartProducts) {
            throw $this->createNotFoundException('Orders not found for customer');
        }

        $cart = new \App\Services\Cart();

        $total = $cart->calculateTotal($cartProducts, $customerId, $customerDiscounts);

        $cartProducts['total'] = $total;

        $serializer = $this->container->get('serializer');
        $response = $serializer->serialize($cartProducts, 'json');

        return new Response($response, 200);
    }

    /**
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


        $cartRepository = $this->getDoctrine()->getRepository(Cart::class);
        $cartProductRepository = $this->getDoctrine()->getRepository(CartProduct::class);

        $cart = $cartRepository->findOneOrCreateCart($data['customer_id']);
        $cartProduct = $cartProductRepository->findOneOrCreateCartProduct($cart, $data['product_id']);

        $cartProduct->setQuantity($cartProduct->getQuantity() + 1);


        $em->persist($cartProduct);
        $em->flush();

        return new Response('Cart successfully updated', 200);
    }

    /**
     * @Rest\Delete("/clean/cart/{customerId}")
     *
     * @param int $customerId
     * @return Response
     */
    public function clearCart(int $customerId)
    {
        $cartRepository = $this->getDoctrine()->getRepository(Cart::class);

        $cartRepository->clearCart($customerId);

        return new Response('Product successfully deleted from cart', 200);
    }

    /**
     *
     * @Rest\Get("/create/order/{customerId}")
     *
     * @param int $customerId
     * @return Response
     */
    public function createOrder(int $customerId)
    {
        $em = $this->getDoctrine()->getManager();

        $cartRepository = $this->getDoctrine()->getRepository(Cart::class);
        $cartProductRepository = $this->getDoctrine()->getRepository(CartProduct::class);
        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
        $orderProductRepository = $this->getDoctrine()->getRepository(OrderProduct::class);

        $cart = $cartProductRepository->getCart($customerId);
        $total = $cartProductRepository->getTotal($customerId);

        if (!$cart) {
            throw $this->createNotFoundException('Orders not found for customer');
        }

        $cart['total'] = $total;

        $order = $orderRepository->createOrder($customerId, $cart);
        $orderProduct = $orderProductRepository->createOrderProduct($order, $cart);

        $em->persist($orderProduct);
        $em->flush();

        $cartRepository->clearCart($customerId);

        return new Response('Your Order completed successfully', 200);
    }
}

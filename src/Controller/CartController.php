<?php

namespace App\Controller;

use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $carts = $entityManager->getRepository(Cart::class)->findAll();
        $cart = [];

        foreach ($carts as $item) {
            $productId = $item->getProductId();

            if (!isset($cart[$productId])) {
                $cart[$productId] = [
                    'product' => $item->getProduct(),
                    'quantity' => 0,
                    'totalPrice' => 0
                ];
            }
            $cart[$productId]['quantity'] += $item->getQuantity();
            $cart[$productId]['totalPrice'] += $item->getQuantity() * $item->getPrice();
        }

        $cartTotal = 0;
        foreach ($carts as $item) {
            $cartTotal += $item->getQuantity() * $item->getPrice();
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'cartTotal' => $cartTotal,
        ]);
    }

    /**
     * @Route("/clear", name="clear", methods={"DELETE"})
     */
    public function deleteAll(EntityManagerInterface $entityManager): Response
    {
        $carts = $entityManager->getRepository(Cart::class)->findAll();

        foreach ($carts as $data) {
            $entityManager->remove($data);
        }

        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

}


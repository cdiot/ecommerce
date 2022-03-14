<?php

namespace App\Controller;

use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    #[Route(path: [
        'en' => '/my-cart',
        'fr' => '/mon-panier'
    ], name: 'cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }

    #[Route(path: [
        'en' => '/cart/add/{id}',
        'fr' => '/panier/ajouter/{id}'
    ], name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    #[Route(path: [
        'en' => '/cart/decrease/{id}',
        'fr' => '/panier/diminuer/{id}'
    ], name: 'decrease_to_cart')]
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }

    #[Route(path: [
        'en' => '/cart/delete/{id}',
        'fr' => '/panier/supprimer/{id}'
    ], name: 'delete_to_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }
}

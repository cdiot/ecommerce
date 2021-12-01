<?php

namespace App\Controller;

use App\Service\Cart;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'order_success')]
    public function index(Cart $cart, OrderRepository $orderRepository, $stripeSessionId): Response
    {
        $order = $orderRepository->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('/');
        }

        if (!$order->getIsPaid()) {
            $cart->remove();
            $order->setIsPaid(1);
            $this->entityManager->flush();
        }

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    #[Route('/commande/erreur/{stripeSessionId}', name: 'order_cancel')]
    public function index(OrderRepository $orderRepository, $stripeSessionId): Response
    {
        $order = $orderRepository->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('/');
        }

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}

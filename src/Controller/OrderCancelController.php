<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    #[Route('/commande/erreur/{stripeSessionId}', name: 'order_cancel')]
    public function index(OrderRepository $orderRepository, Mailer $mailer, $stripeSessionId): Response
    {
        $order = $orderRepository->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('/');
        }

        $mailer->send(
            'Erreur commande #' .  $order->getReference() . ' - Ecommerce | SITE OFFICIEL',
            'bar@ecommerce.com',
            $order->getUser()->getEmail(),
            'emails/order_cancel.html.twig',
            [
                'order' => $order,
            ]
        );

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}

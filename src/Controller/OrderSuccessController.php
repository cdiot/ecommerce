<?php

namespace App\Controller;

use App\Service\Cart;
use App\Repository\OrderRepository;
use App\Service\Mailer;
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
    public function index(Cart $cart, OrderRepository $orderRepository, Mailer $mailer, $stripeSessionId): Response
    {
        $order = $orderRepository->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('/');
        }

        if (!$order->getState() == 0) {
            $cart->remove();
            $order->setState(1);
            $this->entityManager->flush();

            $mailer->send(
                'Commande #' .  $order->getReference() . ' confirmée - Ecommerce | SITE OFFICIEL',
                'bar@ecommerce.com',
                $order->getUser()->getEmail(),
                'emails/order_success.html.twig',
                [
                    'order' => $order,
                ]
            );
        }

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}

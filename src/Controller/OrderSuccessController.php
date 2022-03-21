<?php

namespace App\Controller;

use App\Service\Cart;
use App\Repository\OrderRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class OrderSuccessController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: [
        'en' => '/order/thank-you/{stripeSessionId}',
        'fr' => '/commande/merci/{stripeSessionId}'
    ], name: 'order_success')]
    public function index(
        Cart $cart,
        OrderRepository $orderRepository,
        Mailer $mailer,
        $stripeSessionId,
        TranslatorInterface $translator
    ): Response {
        $order = $orderRepository->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('/');
        }

        if (!$order->getState() == 0) {
            $cart->remove();
            $order->setState(1);
            $this->entityManager->flush();

            $mailer->send(
                $translator->trans('email.subject.order_success', ['reference' => $order->getReference()]),
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

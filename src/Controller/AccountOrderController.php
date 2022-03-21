<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class AccountOrderController extends AbstractController
{
    #[Route(path: [
        'en' => '/account/my-orders',
        'fr' => '/compte/mes-commandes'
    ], name: 'account_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findSuccessOrders($this->getUser());

        return $this->render('account/order.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route(path: [
        'en' => '/account/my-orders/{reference}',
        'fr' => '/compte/mes-commandes/{reference}'
    ], name: 'account_order_show')]
    public function show(OrderRepository $orderRepository, $reference): Response
    {
        $order = $orderRepository->findOneByReference($reference);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order
        ]);
    }
}

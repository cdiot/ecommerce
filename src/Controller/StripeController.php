<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index(OrderRepository $orderRepository, ProductRepository $productRepository, $reference): RedirectResponse
    {
        $products_for_stripe = [];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000';

        $order = $orderRepository->findOneByReference($reference);

        if (!$order) {
            return $this->redirectToRoute('order');
        }

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $product_object = $productRepository->findOneByName($product->getProduct());
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN . "/uploads/" . $product_object->getIllustration()]
                    ],
                    'unit_amount' => $product->getPrice(),
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $products_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN]
                ],
                'unit_amount' => $order->getCarrierPrice(),
            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey('sk_test_51JMIhlJBc4Mr0e4svh35HElXs0sONNHBJ3bJGsrtmw4wo4yjgej6YbWvM7LXryzVUw98T0dlrY1KUV4FZWfuGvqF00TkpoJGd1');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => [
                'card',
            ],
            'line_items' => [
                $products_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $this->entityManager->flush();

        $response = new RedirectResponse($checkout_session->url, 303);

        return $response;
    }
}

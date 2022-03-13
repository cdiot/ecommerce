<?php

namespace App\Controller;

use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('home', ['_locale' => 'en']);
    }

    #[Route('/{_locale<%app.locales%>}', name: 'home')]
    public function index(ProductRepository $productRepository, HeaderRepository $headerRepository): Response
    {
        $bestProducts = $productRepository->findByIsBest(true);
        $headers = $headerRepository->findAll();
        return $this->render('home/index.html.twig', [
            'bestProducts' => $bestProducts,
            'headers' => $headers
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class AccountAddressController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AddressRepository $addressRepository
    ) {
    }

    #[Route(path: [
        'en' => '/account/addresses',
        'fr' => '/compte/adresses'
    ], name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route(path: [
        'en' => '/account/add-an-address',
        'fr' => '/compte/ajouter-une-adresse'
    ], name: 'account_address_add')]
    public function add(Cart $cart, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            if ($cart->get()) {
                return $this->redirectToRoute('order');
            } else {
                return $this->redirectToRoute('account_address');
            }
        }
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: [
        'en' => '/account/modify-an-address/{id}',
        'fr' => '/compte/modifier-une-adresse/{id}'
    ], name: 'account_address_edit')]
    public function edit(Request $request, $id): Response
    {
        $address = $this->addressRepository->findOneById($id);
        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: [
        'en' => '/account/delete-an-address/{id}',
        'fr' => '/compte/supprimer-une-adresse/{id}'
    ], name: 'account_address_delete')]
    public function delete($id): Response
    {
        $address = $this->addressRepository->findOneById($id);
        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('account_address');
    }
}

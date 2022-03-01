<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccountPasswordController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/compte/modifier-mon-mot-de-passe', name: 'account_password')]
    public function index(HttpFoundationRequest $request, UserPasswordHasherInterface $hasher, TranslatorInterface $translator): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();
            if ($hasher->isPasswordValid($user, $old_password)) {
                $new_password = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_password);
                $user->setPassword($password);
                $this->entityManager->flush();
                $this->addFlash('notification', $translator->trans('notification.password_updated.'));
            } else {
                $this->addFlash('notification', $translator->trans('notification.password_incorrect.'));
            }
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

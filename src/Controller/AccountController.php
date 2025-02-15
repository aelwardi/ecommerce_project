<?php

namespace App\Controller;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('/compte/modifier-mot-de-passe', name: 'app_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $from = $this->createForm(PasswordUserType::class, $user, [
            'password_hasher' => $passwordHasher,
        ]);
        $from->handleRequest($request);
        if ($from->isSubmitted() && $from->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Votre mot de passe est correctement mis à jour"
            );
        }
        return $this->render('account/password.html.twig', [
            'modifyPwdForm' => $from->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $from = $this->createForm(RegisterUserType::class, $user);
        $from->handleRequest($request);

        if ($from->isSubmitted() && $from->isValid()) {
            //dd($from->getData());
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Votre compte est correctement créé, veuillez vous connecter."
            );
            return $this->redirectToRoute('app_login');
        }
        return $this->render('register/index.html.twig', [
            'registerForm' => $from->createView()
        ]);
    }
}
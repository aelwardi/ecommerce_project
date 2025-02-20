<?php

namespace App\Controller\Account;


use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class PasswordController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/compte/modifier-mot-de-passe', name: 'app_modify_pwd')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        $from = $this->createForm(PasswordUserType::class, $user, [
            'password_hasher' => $passwordHasher,
        ]);
        $from->handleRequest($request);
        if ($from->isSubmitted() && $from->isValid()) {
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                "Votre mot de passe est correctement mis à jour"
            );
        }
        return $this->render('account/password/index.html.twig', [
            'modifyPwdForm' => $from->createView()
        ]);
    }
}

?>
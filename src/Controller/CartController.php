<?php

namespace App\Controller;

use App\Classe\Card;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Card $card): Response
    {
        return $this->render('cart/index.html.twig', [
            'card' => $card->getCard(),
            'totalWT' => $card->getTotalWT(),
        ]);
    }

    #[Route('/card/add/{id}', name: 'app_cart_add')]
    public function add($id, Card $card, ProductRepository $productRepository, Request $request): Response
    {
        $product = $productRepository->find($id);
        $card->add($product);
        $this->addFlash(
            'success',
            "Produit ajouté au panier"
        );
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/card/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease($id, Card $card): Response
    {
        $card->decrease($id);
        $this->addFlash(
            'success',
            "Produit supprimé du panier"
        );
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/card/remove', name: 'app_cart_remove')]
    public function remove(Card $card): Response
    {
        $card->remove();
        return $this->redirectToRoute('app_home');
    }
}

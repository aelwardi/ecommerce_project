<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/produit/{slug}', name: 'app_product')]
    public function index($slug, ProductRepository $productRepository): Response
        #public function index(#[MapEntity(mapping: ['slug' => 'slug'])] Product $product): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);
        #dd($product);
        if (!$product) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }
}

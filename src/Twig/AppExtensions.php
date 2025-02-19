<?php
namespace App\Twig;

use App\Classe\Card;
use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtensions extends AbstractExtension implements GlobalsInterface
{
    private $categoryRepository, $card;
    public function __construct(CategoryRepository $categoryRepository, Card $card)
    {
        $this->categoryRepository = $categoryRepository;
        $this->card = $card;
    }
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($price)
    {
        return number_format($price, 2, ','). ' €';
    }

    public function getGlobals(): array
    {
        return [
            'allCategories' => $this->categoryRepository->findAll(),
            'fullCardQuantity' => $this->card->fullQuantity(),
        ];
    }
}
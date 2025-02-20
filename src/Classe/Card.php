<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Card
{
    public function __construct(private RequestStack $requestStack)
    {
    }
    public function add($product)
    {
        #$session = $this->requestStack->getSession();
        $card = $this->getCard();
        #dd($session);
        if(isset($card[$product->getId()])){
            $card[$product->getId()] = [
                'object' => $product,
                'qty' => $card[$product->getId()]['qty'] + 1,
            ];
        } else {
            $card[$product->getId()] = [
                'object' => $product,
                'qty' => 1
            ];
        }
        $this->requestStack->getSession()->set('card', $card);
        #dd($this->requestStack->getSession()->get('card'));
    }

    public function decrease($id){
        $card =$this->getCard();

        if($card[$id]['qty'] > 1) {
            $card[$id]['qty']--;
        } else {
            unset($card[$id]);
        }
        $this->requestStack->getSession()->set('card', $card);
    }
    public function getCard()
    {
        return $this->requestStack->getSession()->get('card');
    }

    public function fullQuantity() {
        $card = $this->getCard();
        $quantity = 0;
        if(!isset($card)){
            return $quantity;
        }
        foreach ($card as $product) {
            $quantity += $product['qty'];
        }
        return $quantity;
    }

    public function getTotalWT() {
        $card = $this->getCard();
        $price = 0;
        foreach ($card as $product) {
            $price += ($product['object']->getPriceWT() * $product['qty']);
        }
        return $price;
    }
    public function remove() {
        return $this->requestStack->getSession()->remove('card');
    }
}
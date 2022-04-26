<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index(ProduitRepository  $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'products' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("addToCart/{produit}", name="addToCart")
     */
    public function addToCart(Produit $produit){
        $quantity = 1;
        $orderItem = new OrderItems();
        $orderItem->setProduit($produit);
        $orderItem->setQuantity($quantity);
        return $this->forward('\App\Controller\OrderItemsController::insert', ['item' => $orderItem,]);
    }
}

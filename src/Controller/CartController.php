<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Repository\OrdersItemsRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProduitRepository;
use App\Service\Cart\CartService;
use App\Service\OrderService\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CartController extends AbstractController
{

    /**
     * @Route("/cart", name="cart")
     */
    public function index(Request $request,CartService $cartService , OrdersItemsRepository $orderItemsRepo, ProduitRepository $produitRepository): Response
    {

        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        $bestSellers = $orderItemsRepo->getBestSellers();


        return $this->render('cart/index.html.twig',[
            'items' => $cartService->getCart(),
            'total' => $cartService->getTotal(),
            'orders' => $cartService->getPlacedOrders(),
            'bestSellers' => $bestSellers
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add (Request $request, $id,CartService $cartService){
        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        $cartService->add($id);
        $this->addFlash(
            'info',
            'Item has been added !'
        );
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id,CartService $cartService){

        $cartService->remove($id);
        $this->addFlash(
            'info',
            'Item has been removed !'
        );
        return $this->redirectToRoute("cart");
    }


    /**
     * @Route("/cart/update", methods={"POST"}, name="cart_update")
     */
    public function update(CartService  $cartService , Request $request){

        $cartService->update($request->request->get('id'),$request->request->get('quantity'));
        $this->addFlash(
            'info',
            'Item has been updated !'
        );
        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/cart/orderDetails/{id}" , name="orderDetails")
     */
    public function orderDetails($id, CartService $cartService,OrdersItemsRepository $ordersItemsRepository){
        return $this->render('cart/partials/orderDetails.html.twig',[
            'order' => $cartService->getOrder($id),
            'items' => $ordersItemsRepository -> findBy(['order' =>  $cartService->getOrder($id)])
        ]);
    }

    /**
     * @Route("/cart/getJsonCart/{id}" , name="getJsonCart")
     */
    public function getJsonCart(CartService  $cartService, NormalizerInterface $normalizer){
        $items = $cartService->getJsonCart();

        $jsonContent = $normalizer->normalize($items,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
}

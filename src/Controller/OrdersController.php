<?php

namespace App\Controller;
use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\User;
use App\Repository\OrdersItemsRepository;
use App\Repository\OrdersRepository;
use App\Service\Cart\CartService;
use App\Service\OrderService\OrderService;
use Braintree_ClientToken;
use Doctrine\DBAL\Types\TextType;

use Knp\Component\Pager\PaginatorInterface;
use src\Validation\Contracts\ValidatorInterface;
use src\Validation\Validator;
use srs\Validation\Forms\OrderForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OrdersController extends AbstractController
{


    /**
     * @Route("/orders", name="app_orders")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        $orders = $this->getDoctrine()->getRepository(Orders::class)->findAll();
        $artices = $paginator->paginate(
            $orders,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('orders/index.html.twig', [
            'orders' =>  $artices,
        ]);
    }


    public function insert(Orders $order, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        if (!$order){
            throw $this->createNotFoundException(
                'item is null'
            );
        }

        $entityManager->persist($order);
        $entityManager->flush();

    }


    /**
     * @Route("/orders/remove/{id}", name="order_remove")
     */
    public function remove($id)
    {
        $order = $this->getDoctrine()->getRepository(Orders::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$order){
            throw $this->createNotFoundException(
                'order not found'
            );
        }

        $entityManager->remove($order);
        $entityManager->flush();
        return $this->redirectToRoute("app_orders");

    }


    public function getAll()
    {
        return $this->getDoctrine()->getManager()->getRepository(Orders::class)->findAll();
    }

    public function getOrder($id)
    {
        return $this->getDoctrine()->getManager()->getRepository(Orders::class)->find($id);
    }

    public function getUserOrders(User $user , String $state){
        return $this->getDoctrine()->getRepository(Orders::class)->findBy(['user'=>$user->getOrder(),'state'=>$state,]);
    }

    public function getOrInitUserCart(User $user){
        $order = new Orders();
        if (!getUserOrders($user, "pending")) {
            $order->setUser($user);
            insert($order);
        }
        return getUserOrders($user,"pending")[0];
    }

    /**
     * @Route("placeOrder", name="placeOrder")
     */
    public function placeOrder(CartService $cartService , OrderService  $orderService){

        $orderService ->placeOrder($cartService->getCurrentOrder(),$cartService,$this->getDoctrine()->getManager());
        die('Order Placed !');

    }




}

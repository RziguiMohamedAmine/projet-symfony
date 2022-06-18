<?php
namespace App\Service\Cart;

use Symfony\Component\HttpFoundation\Request;
use App\Controller\CartController;
use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\User;
use App\Repository\OrdersItemsRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use App\Service\OrderItems\OrderItemsService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

class CartService {

    protected $session;
    protected $produitRepository;
    protected $userRepository;
    protected $orderRepo;
    protected $orderItemsRepo;
    protected $entityManager;
    protected $request;

    public function __construct(SessionInterface $session, ProduitRepository $produitRepository,UserRepository $userRepository,OrdersRepository  $ordersRepository, OrdersItemsRepository $orderItemsRepo,EntityManagerInterface $entityManager){

        $this->session = $session;
        $this->produitRepository = $produitRepository;
        $this->userRepository = $userRepository;
        $this->orderRepo = $ordersRepository;
        $this->orderItemsRepo = $orderItemsRepo;
        $this->entityManager = $entityManager;
       // $this->request = $request;

    }

    public function getUser(): User{
       /* $email = $this->request->getSession()->get('_security.last_username');
        $user = $this->userRepository->findOneByEmail($email);
        return $this->session -> get ('user',$user);*/
        return $this->session->get('user',$this->userRepository->find(125));
    }

    public function getPlacedOrders():array{
        return $this->session -> get('placedOrders',$this->orderRepo->findBy([
            'user' => $this->getUser(),
            'state' => "placed"
        ]));
    }

    public function getCurrentOrder():Orders{
       // dd($this->getUser());
        return $this->session -> get('currentOrder',$this->orderRepo->findOneBy([
            'user' => $this->getUser(),
            'state' => "pending"
        ]));

    }

    public function getOrder(int $id) {

        foreach ( $this->getPlacedOrders() as $order ) {
            if ( $order->getId() == $id ) {
                return $order;
            }
        }
    }

    public function add(int $id){

        $cart = $this->session  -> get('cart',[]);
        if(!empty($cart[$id]))
            $cart[$id]++;
        else
            $cart[$id] = 1;

        $orderItem = new OrderItems();
        $orderItem->setQuantity($cart[$id])
            ->setProduit($this->produitRepository->find($id))
            ->setOrder($this->getCurrentOrder());

        OrderItemsService::insertOrUpdate($orderItem, $this->orderItemsRepo, $this->entityManager);
        $this->session->set('cart',$cart);

    }

    public function remove(int $id){

        $cart = $this->session->get('cart',[]);
        $orderItem = new OrderItems();
        $orderItem->setQuantity($cart[$id])
            ->setProduit($this->produitRepository->find($id))
            ->setOrder($this->getCurrentOrder());
        OrderItemsService::delete($orderItem, $this->orderItemsRepo, $this->entityManager);

        if (!empty($cart[$id]))
            unset($cart[$id]);
        $this->session->set('cart',$cart);
    }

    public function clear(){
        $this->session->set('cart',[]);

    }

    public function update(int $id, int $quantity){

        $cart = $this->session  -> get('cart',[]);
        if(!empty($cart[$id]))
            $cart[$id] = $quantity;

        $orderItem = new OrderItems();
        $orderItem->setQuantity($cart[$id])
            ->setProduit($this->produitRepository->find($id))
            ->setOrder($this->getCurrentOrder());

        OrderItemsService::insertOrUpdate($orderItem,$this->orderItemsRepo,$this->entityManager);
        $this->session->set('cart',$cart);
    }


    public function getCart() : array{

        $cart = $this->session->get('cart',[]);



        if (!$cart)
            return $this->initCart();

        $cartWithData=[];
        foreach($cart as $id => $quantity){
            $cartWithData[]=[
                'product' => $this->produitRepository->find($id),
                'quantity' => $quantity
            ];
        }
        //dd($cartWithData);
        return $cartWithData;
    }

    public function getTotal() : float{

        $total =0;
        foreach ($this->getCart() as $item)
            $total += $item['product']->getPrix()*$item['quantity'];

        return $total;
    }

    public function initCart(){

        $cartWithData=[];
        $item = new OrderItems();
        foreach($this->orderItemsRepo->findBy(['order' => $this->getCurrentOrder()]) as $item ){
            $cartWithData[]=[
                'product' => $item->getProduit(),
                'quantity' => $item->getQuantity()
            ];
            $cart[$item->getProduit()->getId()] = $item->getQuantity();
            $this->session->set('cart',$cart);
        }
        // dd ($cartWithData);
        return $cartWithData;
    }


    public function getJsonCart() : array{

        $cart = $this->session->get('cart',[]);



        if (!$cart)
            return $this->initCart();

        $cartWithData=[];
        foreach($cart as $id => $quantity){
            $cartWithData[]=[
                'product' => $this->produitRepository->find($id),
                'quantity' => $quantity
            ];
        }
        //dd($cartWithData);
        return $this->orderItemsRepo->findBy(['order' => $this->getCurrentOrder()]);
    }




}
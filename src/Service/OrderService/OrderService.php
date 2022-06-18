<?php

namespace App\Service\OrderService;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Repository\OrdersItemsRepository;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    public static function insertOrUpdate(Orders $order, EntityManagerInterface $entityManager){

        $dbOrder = $entityManager->find(Orders::class,$order->getId());
        if (!$dbOrder) {
            $dbOrder=$order;
        }
        else
            $dbOrder->setState($order->getState());

        $entityManager->persist($dbOrder);
        $entityManager->flush();
    }

    public static function delete(Orders $order, EntityManagerInterface $entityManager){

        $entityManager->remove($order);
        $entityManager->flush();
    }

    public  function placeOrder(Orders $order, CartService $cartService, EntityManagerInterface $entityManager){

        $order->setState("placed");
        self::insertOrUpdate($order,$entityManager);

        $cartService->clear();
        $newOrder = new Orders();
        $newOrder->setUser($order->getUser());
        $date= new \DateTime();
        $date->setDate(2022,10,28);
        $newOrder->setDate($date);
        $entityManager->persist($newOrder);
        $entityManager->flush();

        return $order;

    }
}
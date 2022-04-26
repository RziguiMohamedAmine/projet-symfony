<?php

namespace App\Service\OrderItems;

use App\Entity\OrderItems;
use App\Repository\OrdersItemsRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderItemsService
{

    public static function insertOrUpdate(OrderItems $item, OrdersItemsRepository $orderItemsRepo, EntityManagerInterface $entityManager){

        $dbItem = $orderItemsRepo->findOneBy(['order'=>$item->getOrder(),'produit'=>$item->getProduit(),]);
        if (!$dbItem) {
            $dbItem=$item;
        }
        else
            $dbItem->setQuantity($item->getQuantity());

        $entityManager->persist($dbItem);
        $entityManager->flush();
    }

    public static function delete(OrderItems $item,OrdersItemsRepository $orderItemsRepo, EntityManagerInterface $entityManager){

            $entityManager->remove($orderItemsRepo->findOneBy(['order'=>$item->getOrder(),'produit'=>$item->getProduit()]));
            $entityManager->flush();
    }
}
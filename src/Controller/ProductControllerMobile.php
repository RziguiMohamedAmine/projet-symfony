<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Equipe;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\AvisRepository;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;



/**
 * @Route("/produit")
 */
class ProductControllerMobile extends AbstractController
{

    /**
     * @Route("/Mobile", name="app_produdgdhgit_index", methods={"GET"})
     */
    public function index()
    {
        $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);

        return new JsonResponse($formatted);
    }

    /**
     * @Route("/Mobile/new", name="app_prodtrtgruit_new", methods={"GET", "POST"})
     * @throws ExceptionInterface
     */
    public function new(Request $request,CategorieRepository $categorieRepository)
    {
        $produit=new Produit();
        $em=$this->getDoctrine()->getManager();
        $nom=$request->get("nom");
        $image=$request->get("image");
        $prix=$request->get("prix");
        $description=$request->get("description");
        $stock=$request->get("stock");
        $idCat=$request->get("idCat");

        $cat=$categorieRepository->find($idCat);

        $produit->setNom($nom);
        $produit->setImage($image);
        $produit->setPrix($prix);
        $produit->setDescription($description);
        $produit->setStock($stock);
        $produit->setIdCat($cat);

        $em->persist($produit);
        $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);


    }


}

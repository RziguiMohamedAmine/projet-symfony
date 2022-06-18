<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/categorie")
 */
class CategorieControllerMobile extends AbstractController
{
    /**
     * @Route("/admin/Mobile", name="app_categordgbdie_index", methods={"GET"})
     */
    public function index()
    {
        $categorie=$this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($categorie);

        return new JsonResponse($formatted);
    }

    /**
     * @Route("/Mobile/newCat", name="app_categobegbrie_new", methods={"GET", "POST"})
     *  @throws ExceptionInterface
     */
    public function new(Request $request)
    {
        $categorie=new Categorie();
        $em=$this->getDoctrine()->getManager();
        $nom=$request->get("nom");


        $categorie->setNom($nom);

        $em->persist($categorie);
        $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($categorie);
        return new JsonResponse($formatted);

    }


}

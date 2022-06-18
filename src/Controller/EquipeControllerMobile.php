<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use App\Repository\JoueurRepository;
use App\Repository\StadeRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
 * @Route("/equipe")
 */
class EquipeControllerMobile extends AbstractController
{
    /**
     * @Route("/adminMobile/", name="app_equipe_indexmob", methods={"GET"})
     */
    public function index()
    {
        $equipe=$this->getDoctrine()->getManager()->getRepository(Equipe::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($equipe);

        return new JsonResponse($formatted);
    }
    /**
     * @Route("/clientMobile/", name="app_equipe_indexFrontMobile", methods={"GET"})
     */
    public function indexFront(JoueurRepository $joueurRepository)
    {

        $joueur=$joueurRepository->ScoreJoueur();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($joueur);

        return new JsonResponse($formatted);

    }


    /**
     * @Route("/adminMobile/new", name="app_equipe_newmob", methods={"GET", "POST"})
     * @throws ExceptionInterface
     */
    public function new(Request $request)
    {
        $equipe = new Equipe();
        $em=$this->getDoctrine()->getManager();
        $nomeq=$request->get("nomeq");
        $logo=$request->get("logo");
        $nomEntreneur=$request->get("nomEntreneur");
        $niveau=$request->get("niveau");
        $stade=$request->get("stade");

        $equipe->setNomeq($nomeq);
        $equipe->setLogo($logo);
        $equipe->setNomEntreneur($nomEntreneur);
        $equipe->setNiveau($niveau);
        $equipe->setStade($stade);

        $em->persist($equipe);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($equipe);
        return new JsonResponse($formatted);

    }

    /**
     * @Route("/adminhgchfMobile/{id}", name="app_equipe_showrrr", methods={"GET"})
     */
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/adminMobile/{id}/edit", name="app_equipe_editmob", methods={"GET", "POST"})
     */
    public function edit(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $equipe=$this->getDoctrine()->getManager()->getRepository(Equipe::class)
            ->find($request->get("id"));

        $equipe->setNomeq($request->get("nom"));
        $equipe->setLogo($request->get("logo"));
        $equipe->setNomEntreneur($request->get("nomEntreneur"));
        $equipe->setNiveau($request->get("niveau"));
        $equipe->setStade($request->get("stade"));

        $em->persist($equipe);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($equipe);
        return new JsonResponse("equipe Modifier avec succés");

    }

    /**
     * @Route("/adminMobile/{id}", name="app_equipe_deletemobtegt",methods={"GET", "POST"})
     * @throws ExceptionInterface
     */
    public function delete(Request $request, Equipe $equipe, EquipeRepository $equipeRepository): Response
    {
        $id=$request->get("id");

        $em=$this->getDoctrine()->getManager();
        $equipe=$em->getRepository(Equipe::class)->find($id);

        if($equipe!=null)
        {
            $em->remove($equipe);
            $em->flush();

            $serializer=new Serializer([new ObjectNormalizer()]);
            $formatted=$serializer->normalize("Equipe a été supprimer avec succés");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Equipe invalid");
    }


    /**
     * @param EquipeRepository $equipeRepository
     * @param JoueurRepository $joueurRepository
     * @param $id
     * @return Response
     *  @Route("/frontMobile/{id}", name="app_equipe_joueurMob", methods={"GET", "POST"})
     */
    public  function ListJoueurByEquipe(EquipeRepository $equipeRepository,JoueurRepository $joueurRepository,$id)
    {
        $equipe = $equipeRepository->find($id);
        $joueur=$joueurRepository->listJoueur($equipe->getId());

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($joueur);

        return new JsonResponse($formatted);
    }


    /**
     * @param EquipeRepository $equipeRepository
     * @param StadeRepository $StadeRepository
     * @param $id
     * @return Response
     *  @Route("/frontMobile/map/{id}", name="app_mobile_equipe_map", methods={"GET", "POST"})
     */
    public  function stadeEquipe(EquipeRepository $equipeRepository,StadeRepository $StadeRepository,$id)
    {
        $equipe = $equipeRepository->find($id);
        $stade=$StadeRepository->mapStade($equipe->getStade(),$equipe->getId());
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($stade);

        return new JsonResponse($formatted);

    }





}

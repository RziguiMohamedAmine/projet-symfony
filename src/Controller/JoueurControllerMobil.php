<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use App\Repository\EquipeRepository;
use App\Repository\JoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
/**
 * @Route("/joueur")
 */
class JoueurControllerMobil extends AbstractController
{
    /**
     * @Route("/adminMobile/", name="app_joueur_indexrzvr", methods={"GET"})
     * @throws ExceptionInterface
     */


    public function index(NormalizerInterface $normalizer)
    {
        $joueur=$this->getDoctrine()->getManager()->getRepository(Joueur::class)->findAll();
        $jsonContent=$normalizer->normalize($joueur,'json');
        return new JsonResponse($jsonContent);
    }



    /**
     * @Route("/adminMobile/new", name="app_joueur_newMobile", methods={"GET", "POST"})
     */
    public function new(Request $request,EquipeRepository $eqrep)
    {
        $joueur = new Joueur();
        $em=$this->getDoctrine()->getManager();

        $nom=$request->get("nom");
        $prenom=$request->get("prenom");
        $poste=$request->get("poste");
        $nationalite=$request->get("nationalite");
        $taille=$request->get("taille");
        $poids=$request->get("poids");
        $idEquipe=$request->get("idEquipe");
        $image=$request->get("image");

        $equipe=$eqrep->find($idEquipe);
        $joueur->setNom($nom);
        $joueur->setPrenom($prenom);
        $joueur->setPoste($poste);
        $joueur->setNationalite($nationalite);

        $joueur->setDateNaiss(date_create_from_format("d/m/Y",$request->get("dateNaiss")));
        $joueur->setTaille($taille);
        $joueur->setPoids($poids);
        $joueur->setIdEquipe($equipe);
        $joueur->setImage($image);

        $em->persist($joueur);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($joueur);
        return new JsonResponse($formatted);


    }

    /**
     * @Route("/admin/{id}", name="app_joueur_showrvz", methods={"GET"})
     */
    public function show(Joueur $joueur): Response
    {
        return $this->render('joueur/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    /**
     * @Route("/adminMobile/{id}/edit", name="app_joueur_editzrvr", methods={"GET", "POST"})
     * @throws ExceptionInterface
     */
    public function edit(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $joueur=$this->getDoctrine()->getManager()->getRepository(Joueur::class)
            ->find($request->get("id"));


        $joueur->setNom($request->get("nom"));
        $joueur->setPrenom($request->get("prenom"));
        $joueur->setPoste($request->get("poste"));
        $joueur->setNationalite($request->get("nationalite"));
        $joueur->setDateNaiss($request->get("dateNaiss"));
        $joueur->setTaille($request->get("taille"));
        $joueur->setPoids($request->get("poids"));
        $joueur->setIdEquipe($request->get("idEquipe"));
        $joueur->setImage($request->get("image"));

        $em->persist($joueur);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($joueur);
        return new JsonResponse("Joueur Modifier avec succés");

    }

    /**
     * @Route("/adminMobile/{id}", name="app_joueur_deletevrrz", methods={"GET", "POST"})
     * @throws ExceptionInterface
     */
    public function delete(Request $request)
    {
        $id=$request->get("id");

        $em=$this->getDoctrine()->getManager();
        $joueur=$em->getRepository(Joueur::class)->find($id);

        if($joueur!=null)
        {
            $em->remove($joueur);
            $em->flush();

            $serializer=new Serializer([new ObjectNormalizer()]);
            $formatted=$serializer->normalize("Joueur a été supprimer avec succés");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Joueur invalid");

    }
}

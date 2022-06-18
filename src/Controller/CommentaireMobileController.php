<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Commentaire;
use App\Entity\Like;
use App\Form\CommentaireType;
use App\Repository\BlogRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

class CommentaireMobileController extends AbstractController
{

    /**
     * @Route("/add_comment/mobile/{des}/{temp}/{idb}", name="add_comment_mobile", methods={"GET","POST"})
     */
    public function add_comment($des,$temp,$idb,BlogRepository $blogRepository,CommentaireRepository $repository, NormalizerInterface  $normalizer)
    {
        $commentaire = new Commentaire();
        $commentaire->setDescrp($des);
        $commentaire->setTempsComm(new \DateTime($temp));
        $blog = $blogRepository->find($idb);
        $commentaire->setBlog($blog);
        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);//Add
        $em->flush();
        $coms = $repository->findAll();
        $json = $normalizer->normalize($coms, "json",['groups' => ['comm','blog']]);

        return new JsonResponse($json);

    }
    /**
     * @Route("/edit_comment/mobile/{id}/{des}/{temp}/{idb}", name="edit_comment_mobile", methods={"GET","POST"})
     */
    public function edit_comment($id,$des,$temp,$idb,BlogRepository $blogRepository,CommentaireRepository $repository, NormalizerInterface  $normalizer)
    {  $commentaire = $repository->find($id);

        $commentaire->setDescrp($des);
        $commentaire->setTempsComm(new \DateTime($temp));
        $blog = $blogRepository->find($idb);
        $commentaire->setBlog($blog);
        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);//Add
        $em->flush();
        $coms = $repository->findAll();
        $json = $normalizer->normalize($coms, "json",['groups' => ['comm','blog']]);

        return new JsonResponse($json);

    }
    /**
     * @Route("/commentaire/mobile", name="commentaire_mobile", methods={"GET","POST"})
     */
    public function commentaire_mobile(CommentaireRepository $repository, NormalizerInterface  $normalizer)
    {

        $coms = $repository->findAll();
        $json = $normalizer->normalize($coms, "json",['groups' => ['comm','blog']]);

        return new JsonResponse($json);

    }
    /**
     * @Route("/delete_commentaire/mobile/{id}", name="delete_commentaire_mobile", methods={"GET","POST"})
     */
    public function delete_commentaire(Commentaire $commentaire,CommentaireRepository $repository, NormalizerInterface  $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($commentaire);
        $em->flush();
        $coms = $repository->findAll();
        $json = $normalizer->normalize($coms, "json",['groups' => ['comm','blog']]);

        return new JsonResponse($json);


    }



}

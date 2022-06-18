<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/User")
 */
class UserControllerMobile extends AbstractController
{
    /**
     * @Route("/adminMobileuser", name="apetetp_user_index", methods={"GET"})
     */
    public function index()
    {
        $user=$this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($user);

        return new JsonResponse($formatted);
    }


    /**
     * @Route("/adminMobile/{id}", name="app_usvrzer_delete",methods={"GET", "POST"})
     *  @throws ExceptionInterface
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        $id=$request->get("id");

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($id);

        if($user!=null)
        {
            $em->remove($user);
            $em->flush();

            $serializer=new Serializer([new ObjectNormalizer()]);
            $formatted=$serializer->normalize("User a été supprimer avec succés");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id User invalid");
    }







}

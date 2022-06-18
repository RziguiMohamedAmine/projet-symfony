<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Like;
use App\Form\BlogType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use Symfony\Component\HttpFoundation\JsonResponse;




class BlogMobileController extends AbstractController
{


    /**
     * @Route("/blog/mobile", name="blog_mobile", methods={"GET","POST"})
     */
    public function blog_mobile(BlogRepository $repository, NormalizerInterface  $normalizer)
    {

        $blogs = $repository->findAll();
        $json = $normalizer->normalize($blogs, "json",['groups' => ['blog']]);

        return new JsonResponse($json);

    }
    /**
     * @Route("/add_blog/mobile/{titre}/{contenu}/{image}", name="add_blog_mobile", methods={"GET","POST"})
     */
    public function add_blog($contenu,$image,$titre,BlogRepository $repository, NormalizerInterface  $normalizer)
    {
        $blog = new Blog();
        $blog->setTitre($titre);
        $blog->setImage($image);
        $blog->setContenu($contenu);
        $em = $this->getDoctrine()->getManager();
        $em->persist($blog);//Add
        $em->flush();// refreche


        $blogs = $repository->findAll();
        $json = $normalizer->normalize($blogs, "json",['groups' => ['blog']]);

        return new JsonResponse($json);

    }
    /**
     * @Route("/delete_blog/mobile/{id}", name="delete_blog_mobile", methods={"GET","POST"})
     */
    public function delete_blog(Blog $blog,BlogRepository $repository, NormalizerInterface  $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();
        $blogs = $repository->findAll();
        $json = $normalizer->normalize($blogs, "json",['groups' => ['blog']]);

        return new JsonResponse($json);

    }
    /**
     * @Route("/edit_blog/mobile/{id}/{titre}/{contenu}/{image}", name="edit_blog_mobile", methods={"GET","POST"})
     */
    public function edit_blog(Blog $blog,$contenu,$image,$titre,BlogRepository $repository, NormalizerInterface  $normalizer)
    {

        $blog->setTitre($titre);
        $blog->setImage($image);
        $blog->setContenu($contenu);
        $em = $this->getDoctrine()->getManager();
        $em->persist($blog);
        $em->flush();


        $blogs = $repository->findAll();
        $json = $normalizer->normalize($blogs, "json",['groups' => ['blog']]);

        return new JsonResponse($json);

    }




//partie json
    /**
     * @Route("/blogList", name="liste_blogs_json")
     */
    public function  listblogsJson(NormalizerInterface $Normalizer) {

        $rep=$this->getDoctrine()->getRepository(Blog::class);
        $blog=$rep->findAll();


        $jsonContent=$Normalizer->normalize($blog,'json',['groups'=>'post:read']);
        return new Response (json_encode($jsonContent));



    }


    /**
     * @Route("/deleteBlogJson/{id}", name="deleteBlogJson" ,methods = {"GET", "POST"})
     */


    public function deleteBlogJson(Request $request,NormalizerInterface $Normalizer,$id) {

        $em=$this->getDoctrine()->getManager();
        $blogs=$em->getRepository(Blog::class)->find($id);
        $em->remove($blogs);
        $em->flush();
        $jsonContent=$Normalizer->normalize($blogs,'json',['groups' => 'post:read']);
        return new Response("Event Deleted successfuly".json_encode($jsonContent));

    }

    /**
     * @Route("/addBlogJson", name="add_blogs_json",methods = {"GET", "POST"})
     *
     */
    public function  addblogsJson(Request $request,NormalizerInterface $Normalizer)
    {
        $blogs=new Blog();
        $titre = $request->query->get("titre");
        $image = $request->query->get("image");
        $contenu = $request->query->get("contenu");


        $em = $this->getDoctrine()->getManager();
        //$date = new \DateTime('now');
        $blogs->setTitre($titre);
        $blogs->setImage($image);
        $blogs->setContenu($contenu);





        $em->persist($blogs);
        $em->flush();

        $jsonContent=$Normalizer->normalize($blogs,'json',['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));


    }

    /**
     * @Route("/updateBlogJson", name="update_event_Json" ,methods = {"GET", "POST"})

     */
    public function modifierBlog(Request $request,NormalizerInterface $Normalizer) {
        $em = $this->getDoctrine()->getManager();
        $blogs = $this->getDoctrine()->getManager()
            ->getRepository(Blog::class)
            ->find($request->get("id"));

        $blogs->setContenu($request->get("contenu"));
        $blogs->setTitre($request->get("titre"));
        $blogs->setImage($request->get("image"));



        $em->persist($blogs);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($blogs);
        return new JsonResponse("Event was modified successfully!");


    }

}
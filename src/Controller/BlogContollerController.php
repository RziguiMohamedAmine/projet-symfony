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


/**
 * @Route("/Blog")
 */
class BlogContollerController extends AbstractController
{
   
        /**
     * @Route("/", name="display_blog")
     */
    public function index(BlogRepository $repository): Response
    {
      
        $blogs = $repository->findAll();
         return $this->render('blog/index.html.twig', [
            'b'=>$blogs
        ]);
    }
    /**
     * @Route("/ss", name="display_blog_front")
     */
    public function indexf(BlogRepository $repository): Response
    {

        $blogs = $repository->findAll();
        return $this->render('userDorsaf/index.html.twig', [
            'b'=>$blogs
        ]);
    }
 /**
     * @Route("/admin", name="display_admin")
     */
    public function indexAdmin(): Response
    {

        return $this->render('admin/index.html.twig'
        );
    }

    /**
     * @Route("/front/blog", name="display_front")
     */
    public function indexfront(BlogRepository $repository): Response
    {
        $blogs = $repository->findAll();
        return $this->render('userDorsaf/index.html.twig', [
            'b'=>$blogs
        ]);

    }



   
    /**
     * @Route("/addBlog", name="addBlog")
     */
    public function addBlog(Request $r): Response
    {
        $blog = new Blog();

        $form = $this->createForm(BlogType::class,$blog);

        $form->handleRequest($r);

        if($form->isSubmitted() && $form->isValid()) {
            $ImageFile = $form->get('image')->getData();
            if ($ImageFile) {

                // this is needed to safely include the file name as part of the URL

                $newFilename = md5(uniqid()).'.'.$ImageFile->guessExtension();
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/images';
                // Move the file to the directory where brochures are stored
                try {
                    $ImageFile->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'ImageFilename' property to store the PDF file name
                // instead of its contents
                $blog->setImage($newFilename);}
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);//Add
            $em->flush();

            return $this->redirectToRoute('display_blog');
        }
        return $this->render('blog/createBlog.html.twig',['f'=>$form->createView()]);

    }


    /**
     * @Route("/removeBlog/{id}", name="supp_blog")
     */
    public function suppressionBlog(Blog  $blog): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();

        return $this->redirectToRoute('display_blog');


    }

  /**
     * @Route("/modifBlog/{id}", name="modifBlog")
     */
    public function modifBlog(Request $request,$id): Response
    {
        $blog = $this->getDoctrine()->getManager()->getRepository(Blog::class)->find($id);

        $form = $this->createForm(BlogType::class,$blog);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ImageFile = $form->get('image')->getData();
            if ($ImageFile) {

                // this is needed to safely include the file name as part of the URL

                $newFilename = md5(uniqid()).'.'.$ImageFile->guessExtension();
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/images';
                // Move the file to the directory where brochures are stored
                try {
                    $ImageFile->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'ImageFilename' property to store the PDF file name
                // instead of its contents
                $blog->setImage($newFilename);}
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('display_blog');
        }
        return $this->render('blog/updateBlog.html.twig',['f'=>$form->createView()]);




    }


    /**
         * @Route("/back_consulter_publ/{id}", name="consulter_publ")
         */
        public function consulter_Publ_back(int $id,Request $r): Response
        {
            $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
            $nblikes = $this->getDoctrine()->getRepository(Like::class)->numberoflikes($id);
            $nbdislikes = $this->getDoctrine()->getRepository(Like::class)->numberofdislikes($id);
            $comment = $this->getDoctrine()->getRepository(Commentaire::Class)->findByidblog($id);

            return $this->render('userDorsaf/consulterBlogfront.html.twig', [ 'blog'=> $blog, 'commentaires'=> $comment, 'like' => $nblikes, 'dislike' => $nbdislikes]);
     
        }

    /**
     * @Route("/affichcomm/{id}", name="affichcomm")
     */
    public function affichercomm(Blog  $blog): Response
    {
        $id=$blog->getId();
        $bb=$this->getDoctrine()->getRepository(Blog::class)->find($id);
        $comment = $this->getDoctrine()->getRepository(Commentaire::Class)->findByidblog($id);
        return $this->render('commentairess/index.html.twig', [
            'commentaires' => $comment,'blog'=>$bb,
        ]);


    }





    }

<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Commentaire;
use App\Entity\Like;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentback", name="display_comment")
     */
    public function  comment(): Response
    {

        $commentaire = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->findAll();
        return $this->render('admin/affichcommentback.html.twig', [
            'c'=>$commentaire
        ]);
    }


    /**
     * @Route("/addComment/{id}", name="addComment", methods={"GET","POST"})
     */
    public function addCommmnet(Request $request,Blog $blog/*, User $user, UserRepository $userRepository,$id*/): Response
    {

        $id=$blog->getId();
        $comments = $this->getDoctrine()->getRepository(Commentaire::Class)->existantComment($id);
        $commentaire = new Commentaire();
        if($comments == null) {
            if (isset($_POST['comment'])) {
                $contenu = $_POST['comment'];

            if ($contenu == "") {

            } else {
                $bad_words = array("mauvais", "non professionel", "stupid","fuck");
                $test1 = str_ireplace($bad_words, "****", $contenu);
                $commentaire->setBlog($blog);
                $commentaire->setTempsComm(new \DateTime());
                $commentaire->setDescrp($test1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($commentaire);
                $entityManager->flush();
              //  $user=$userRepository->find($id);
               // $userRepository->banner($user->getId());

            }
        }
        }
        else
        {
            if (($_POST['action']) == "Commenter")
            {
                $contenu = $_POST['comment'];
                if ($contenu == "")
                {

                }
                else
                {
                    $bad_words = array("mauvais", "non professionel", "stupid");
                    $test1=str_ireplace($bad_words,"****",$contenu);
                    $commentaire->setBlog($blog);
                    $commentaire->setTempsComm(new \DateTime());
                    $commentaire->setDescrp($test1);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($commentaire);
                    $entityManager->flush();

                }
            }
            else
            {
                $contenu = $_POST['comment'];
                if ($contenu == "")
                {

                }
                else
                {   $bad_words = array("mauvais", "non professionel", "stupid");
                    $test1=str_ireplace($bad_words,"****",$contenu);
                    $idr = $comments[0]->getIdCommentaire();
                    $this->getDoctrine()
                        ->getRepository(Commentaire::class)
                        ->createQueryBuilder('c')
                        ->update()
                        ->set('c.descrp','?1')
                        ->setParameter(1,$test1)
                        ->where('c.id = ?2')
                        ->setParameter(2,$idr)
                        ->getQuery()
                        ->execute()
                    ;

                }
            }
        }

        $comment = $this->getDoctrine()->getRepository(Commentaire::Class)->findByidblog($id);
        $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
        $nblikes = $this->getDoctrine()->getRepository(Like::class)->numberoflikes($id);
        $nbdislikes = $this->getDoctrine()->getRepository(Like::class)->numberofdislikes($id);

        return $this->render('userDorsaf/consulterBlogfront.html.twig', [
            'blog'=> $blog, 'commentaires'=> $comment, 'like' => $nblikes, 'dislike' => $nbdislikes
        ]);

    }

    /**
     * @Route("/modifComm/{id}", name="modifComm")
     */
    public function modifComm(Request $request,$id): Response
    {
        $Comm = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->find($id);

        $form = $this->createForm(CommentaireType::class, $Comm);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Comm->setTempsComm(new \DateTimeImmutable());
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('display_comment');
        }
        return $this->render('admin/formUpdateCommentaire.html.twig', ['f' => $form->createView()]);


    }




    /**
     * @Route("/removeComment/{id}", name="supp_comm")
     */
    public function suppressionBlog(Commentaire $blog): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();

        return $this->redirectToRoute('display_blog');


    }






}

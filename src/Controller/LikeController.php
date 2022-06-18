<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Commentaire;
use App\Entity\Like;
use App\Form\LikeType;
use App\Repository\BlogRepository;
use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

/**
 * @Route("/like")
 */
class LikeController extends AbstractController
{
    /**
     * @Route("/", name="app_like_index", methods={"GET"})
     */
    public function index(LikeRepository $likeRepository): Response
    {
        return $this->render('like/index.html.twig', [
            'likes' => $likeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="like_new_like", methods={"GET","POST"})
     */
    public function new_like(Request $request,Blog $blog, $id, BlogRepository $blogRepository): Response
    {
        $like = new like();
        $form = $this->createForm(likeType::class, $like);
        $form->handleRequest($request);




//        $id=$blog->getId();

        $like = $this->getDoctrine()->getRepository(Like::Class)->existantLike($id);

        if ($like == null)
        {
            $like =new Like();
            $like->setBlog($blogRepository->find($id));
            $like->setTypelike('like');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($like);
            $entityManager->flush();

        }
        else
        {
            $idr = $like[0]->getId();
            $this->getDoctrine()
                ->getRepository(Like::class)
                ->createQueryBuilder('r')
                ->update()
                ->set('r.typeLike','?1')
                ->setParameter(1,'like')
                ->where('r.id = ?2')
                ->setParameter(2,$idr)
                ->getQuery()
                ->execute()
            ;

        }


        $comment = $this->getDoctrine()->getRepository(Commentaire::Class)->findByidblog($id);
        $nblikes = $this->getDoctrine()->getRepository(Like::class)->numberoflikes($id);
        $nbdislikes = $this->getDoctrine()->getRepository(Like::class)->numberofdislikes($id);




        return $this->render('userDorsaf/consulterBlogfront.html.twig', [
            'blog' => $blog, 'commentaires'=> $comment, 'like' => $nblikes, 'dislike' => $nbdislikes
        ]);
    }

    /**
     * @Route("/{id}/neww", name="like_new_dislike", methods={"GET","POST"})
     */
    public function new_dislike(Request $request,blog $blog, BlogRepository $blogRepository, $id): Response
    {
        $like = new Like();
        $form = $this->createForm(LikeType::class, $like);
        $form->handleRequest($request);





//        $id=$blog->getId();

        $like = $this->getDoctrine()->getRepository(Like::Class)->existantlike($id);
        if ($like == null)
        {

            $like =new Like();
            $like->setBlog($blogRepository->find($id));
            $like->setTypelike('dislike');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($like);
            $entityManager->flush();

        }
        else
        {
            $idr = $like[0]->getId();
            $this->getDoctrine()
                ->getRepository(Like::class)
                ->createQueryBuilder('r')
                ->update()
                ->set('r.typeLike','?1')
                ->setParameter(1,'dislike')
                ->where('r.id = ?2')
                ->setParameter(2,$idr)
                ->getQuery()
                ->execute()
            ;

        }


        $comment = $this->getDoctrine()->getRepository(Commentaire::Class)->findByidblog($id);
        $nblikes = $this->getDoctrine()->getRepository(Like::class)->numberoflikes($id);
        $nbdislikes = $this->getDoctrine()->getRepository(Like::class)->numberofdislikes($id);


        return $this->render('userDorsaf/consulterBlogfront.html.twig', [
            'blog' => $blog, 'commentaires'=> $comment, 'like' => $nblikes, 'dislike' => $nbdislikes
        ]);
    }
}

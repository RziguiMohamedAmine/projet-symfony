<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wishlist;
use App\Form\WishlistType;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use App\Repository\WishlistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Intl\Timezones;

/**
 * @Route("/wishlist")
 */
class WishlistController extends AbstractController
{
    /**
     * @Route("/", name="app_wishlist_index", methods={"GET"})
     */
    public function index(Request $request,UserRepository $userRepository,WishlistRepository $wishlistRepository): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        $user = $userRepository->findOneByEmail($email);
        $products = $wishlistRepository->findProductInWishList($user);
        return $this->render('wishlist/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/new/{id_produit}", name="app_wishlist_new", methods={"GET", "POST"})
     */
    public function new(Request $request,WishlistRepository $wishlistRepository, ProduitRepository $produitRepository, UserRepository $userRepository, $id_produit): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        $user = $userRepository->findOneByEmail($email);


        $produit = $produitRepository->find($id_produit);

        $wishlist = $wishlistRepository->findOneBy(['user'=>$user]);
        if($wishlist == null ) {
            $wishlist = new Wishlist();
            $wishlist->setUser($userRepository->findOneByEmail($email));
        }
        $wishlist->addProduct($produit);
        $wishlistRepository->add($wishlist);
        return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="app_wishlist_show", methods={"GET"})
     */
    public function show(Wishlist $wishlist): Response
    {
        return $this->render('wishlist/show.html.twig', [
            'wishlist' => $wishlist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_wishlist_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Wishlist $wishlist, WishlistRepository $wishlistRepository): Response
    {
        $form = $this->createForm(WishlistType::class, $wishlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishlistRepository->add($wishlist);
            return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wishlist/edit.html.twig', [
            'wishlist' => $wishlist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_wishlist_delete", methods={"POST"})
     */
    public function delete(Request $request, Wishlist $wishlist, WishlistRepository $wishlistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wishlist->getId(), $request->request->get('_token'))) {
            $wishlistRepository->remove($wishlist);
        }

        return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
    }
}

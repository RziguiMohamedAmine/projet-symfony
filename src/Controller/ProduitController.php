<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\AvisRepository;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/front", name="app_produit_index_front", methods={"GET"})
     */
    public function produitfront(Request $request,ProduitRepository $produitRepository, CategorieRepository $categorieRepository,UserRepository $userRepository): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        $user = $userRepository->findOneByEmail($email);
        if($user != null){
            $produit = $produitRepository->getAvisAndProduit($user->getId());
        }else{
            $produit = $produitRepository->getAvisAndProduit(0);
        }

        return $this->render('produit/Produitfront.html.twig', [
            'produit'=>$produit,
            'categorie'=> $categorieRepository->findAll()
        ]);
    }
    /**
     * @Route("/", name="app_produit_index", methods={"GET"})
     */
    public function index(Request $request,ProduitRepository $produitRepository): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=pathinfo($form['image']->getData()->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $file.'-'.uniqid().'.'.$form['image']->getData()->guessExtension();

            try {
                $form['image']->getData()->move(
                    $this->getParameter('logo_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $produit->setImage($newFilename);

            $produitRepository->add($produit);

            $produit->setCode($produit->getId()*1000+12*6);
            $produitRepository->add($produit);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id_categorie}", name="app_produit_show", methods={"GET"})
     * @param ProduitRepository $produitRepository
     * @param CategorieRepository $categorieRepository
     * @param $id_categorie
     * @return Response
     */
    public function show(Request $request,UserRepository $userRepository,ProduitRepository $produitRepository, CategorieRepository $categorieRepository, $id_categorie): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        $user = $userRepository->findOneByEmail($email);
        if($user != null){
            $produit =  $produitRepository->getAvisAndProduitbyCategory($user->getId(),$id_categorie);
        }else{
            $produit = $produitRepository->getAvisAndProduitbyCategory(0,$id_categorie);
        }
        return $this->render('produit/Produitfront.html.twig', [
            'produit'=> $produit,
            'categorie'=> $categorieRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=pathinfo($form['image']->getData()->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $file.'-'.uniqid().'.'.$form['image']->getData()->guessExtension();

            try {
                $form['image']->getData()->move(
                    $this->getParameter('logo_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }  $produit->setImage($newFilename);
            $produitRepository->add($produit);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/star/{id}", name="app_produit_star", methods={"POST"})
     */
    public function addStar(Request $request, Produit $produit,AvisRepository $avisRepository, UserRepository $userRepository, $id): Response
    {
        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        $avisVal =  $request->request->get("whatever3") ;
        $email = $request->getSession()->get('_security.last_username');

        $user = $userRepository->findOneByEmail($email);
        $avis = new Avis();

        $avis->setIdProduit($produit);
        $avis->setIdUser($user);
        $avis1 = $avisRepository->findBy(['idUser'=> $user->getId(), 'idProduit' => $produit->getId()]);
        if($avis1 != []){
            $avis = $avis1[0];
        }
        $avis->setAvis($avisVal+0);
        $avisRepository->add($avis);

        return $this->redirectToRoute('app_produit_index_front', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("addToCart/{produit}", name="addToCart")
     */
    public function addToCart(Request $request,Produit $produit){
        $email = $request->getSession()->get('_security.last_username');
        if($email == null){
            return $this->redirectToRoute('app_login');
        }
        $quantity = 1;
        $orderItem = new OrderItems();
        $orderItem->setProduit($produit);
        $orderItem->setQuantity($quantity);
        return $this->forward('\App\Controller\OrderItemsController::insert', ['item' => $orderItem,]);
    }








}

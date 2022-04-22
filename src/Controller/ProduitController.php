<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
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
    public function produitfront(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {

        return $this->render('produit/Produitfront.html.twig', [
            'produit'=> $produitRepository->findAll(),
            'categorie'=> $categorieRepository->findAll()
        ]);
    }
    /**
     * @Route("/", name="app_produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {

        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
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
    public function show(ProduitRepository $produitRepository, CategorieRepository $categorieRepository, $id_categorie): Response
    {
        $produit =  $produitRepository->findBy(array('idCat'=>$id_categorie));
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
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }


}

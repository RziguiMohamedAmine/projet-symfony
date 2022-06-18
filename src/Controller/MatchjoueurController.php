<?php

namespace App\Controller;

use App\Entity\Matchjoueur;
use App\Form\MatchjoueurType;
use App\Repository\MatchjoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/matchjoueur")
 */
class MatchjoueurController extends AbstractController
{
    /**
     * @Route("/", name="app_matchjoueur_index", methods={"GET"})
     */
    public function index(MatchjoueurRepository $matchjoueurRepository): Response
    {
        return $this->render('matchjoueur/index.html.twig', [
            'matchjoueurs' => $matchjoueurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_matchjoueur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MatchjoueurRepository $matchjoueurRepository): Response
    {
        $matchjoueur = new Matchjoueur();
        $form = $this->createForm(MatchjoueurType::class, $matchjoueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matchjoueurRepository->add($matchjoueur);
            return $this->redirectToRoute('app_matchjoueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('matchjoueur/new.html.twig', [
            'matchjoueur' => $matchjoueur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_matchjoueur_show", methods={"GET"})
     */
    public function show(Matchjoueur $matchjoueur): Response
    {
        return $this->render('matchjoueur/show.html.twig', [
            'matchjoueur' => $matchjoueur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_matchjoueur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Matchjoueur $matchjoueur, MatchjoueurRepository $matchjoueurRepository): Response
    {
        $form = $this->createForm(MatchjoueurType::class, $matchjoueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matchjoueurRepository->add($matchjoueur);
            return $this->redirectToRoute('app_matchjoueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('matchjoueur/edit.html.twig', [
            'matchjoueur' => $matchjoueur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_matchjoueur_delete", methods={"POST"})
     */
    public function delete(Request $request, Matchjoueur $matchjoueur, MatchjoueurRepository $matchjoueurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matchjoueur->getId(), $request->request->get('_token'))) {
            $matchjoueurRepository->remove($matchjoueur);
        }

        return $this->redirectToRoute('app_matchjoueur_index', [], Response::HTTP_SEE_OTHER);
    }
}

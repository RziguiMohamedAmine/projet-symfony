<?php

namespace App\Controller;

use App\Entity\Matchs;
use App\Form\Matchs1Type;
use App\Repository\MatchsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/matchs")
 */
class MatchsController extends AbstractController
{
    /**
     * @Route("/", name="app_matchs_index", methods={"GET"})
     */
    public function index(MatchsRepository $matchsRepository): Response
    {
        return $this->render('matchs/index.html.twig', [
            'matchs' => $matchsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_matchs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MatchsRepository $matchsRepository): Response
    {
        $match = new Matchs();
        $form = $this->createForm(Matchs1Type::class, $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $match->setSaison(str_replace("/", "", $match->getSaison()));
            $matchsRepository->add($match);
            return $this->redirectToRoute('app_matchs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('matchs/new.html.twig', [
            'match' => $match,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_matchs_show", methods={"GET"})
     */
    public function show(Matchs $match): Response
    {
        return $this->render('matchs/show.html.twig', [
            'match' => $match,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_matchs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Matchs $match, MatchsRepository $matchsRepository): Response
    {
        $form = $this->createForm(Matchs1Type::class, $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matchsRepository->add($match);
            return $this->redirectToRoute('app_matchs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('matchs/edit.html.twig', [
            'match' => $match,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/{id}", name="app_matchs_delete", methods={"POST"})
     */
    public function delete(Request $request, Matchs $match, MatchsRepository $matchsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $match->getId(), $request->request->get('_token'))) {
            $matchsRepository->remove($match);
        }

        return $this->redirectToRoute('app_matchs_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/tirageausort/{saison}", name="app_matchs_tirage_au_sort")
     */
    public function tirageAuSort($saison, MatchsRepository $matchsRepository): Response
    {
        $matchsRepository->trigeausort($saison);
        return $this->redirectToRoute('app_matchs_index', [], Response::HTTP_SEE_OTHER);
    }


}

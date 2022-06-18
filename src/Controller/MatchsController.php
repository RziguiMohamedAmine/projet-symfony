<?php

namespace App\Controller;

use App\Entity\Matchs;
use App\Form\Matchs1Type;
use App\Form\ResultType;
use App\Form\TirageAuSortType;
use App\Repository\MatchsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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
            'matchs' => $matchsRepository->findBy(array(), array('date' => 'DESC')),
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

        $now = new DateTime();
        $dateMatch = $form->get("date")->getData();

        if ($dateMatch < $now && $form->isSubmitted()) {
            $form->get("date")->addError(new FormError("date doit etre au future"));
            return $this->render('matchs/new.html.twig', [
                'match' => $match,
                'form' => $form->createView(),
            ]);
        }
        if ($form->isSubmitted() && $form->isValid()) {


            if ($matchsRepository->haveMatch($match->getEquipe1(), $match->getDate()) == []) {
                if ($matchsRepository->haveMatch($match->getEquipe2(), $match->getDate()) == []) {
                    $match->setSaison(str_replace("/", "", $match->getSaison()));
                    $matchsRepository->add($match);
                    $this->addFlash('success', 'match ajoutée avec succées');
                    return $this->redirectToRoute('app_matchs_index', [], Response::HTTP_SEE_OTHER);
                } else {
                    $this->addFlash('fail', $match->getEquipe2() . ' a un match pour ' . $match->getDate()->format('d-m-y'));

                }

            } else {
                $this->addFlash('fail', $match->getEquipe1() . ' a un match pour ' . $match->getDate()->format('d-m-y'));
            }

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

        $match->setSaison(substr($match->getSaison(), 0, 4) . '/' . substr($match->getSaison(), 4));
        $form = $this->createForm(Matchs1Type::class, $match);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $match->setSaison(str_replace("/", "", $match->getSaison()));
            $matchsRepository->add($match);
            $this->addFlash('success', 'match changer avec succée');
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
            $this->addFlash('success', 'match Suprimée avec succée');
            $matchsRepository->remove($match);
        }

        return $this->redirectToRoute('app_matchs_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/tirageausort/form", name="app_matchs_tirage_au_sort_form")
     */
    public function tirageAuSortForm(Request $request, MatchsRepository $matchsRepository): Response
    {
        $form = $this->createForm(TirageAuSortType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $saison = $form["Saison"]->getData();
            $saison = str_replace("/", "", $saison);
            $date = $form["Date"]->getData();
            $result = $matchsRepository->trigeausort($saison, $date);
            if ($result == "true") {

                $this->addFlash('success', 'Tirage Au Sort de saison' . $saison . ' effectuée avec succée <ul> <li> création des matchs</li><li> création de table de classment</li></ul>');
            } else {
                $this->addFlash('fail', $result);

            }

        }

        return $this->render('matchs/TirageAuSortForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/result/{id}", name="app_matchs_update_result", methods={"POST", "GET"})
     */
    public function result(Request $request, Matchs $match, MatchsRepository $matchsRepository): Response
    {
        dump($match);
        $form = $this->createForm(ResultType::class, [
            'equipe1' => $match->getEquipe1()->getNomeq(),
            'equipe2' => $match->getEquipe2()->getNomeq(),

        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $nbBut1 = $form->get("nbBut1")->getData();
                $nbBut2 = $form->get('nbBut2')->getData();

                $matchsRepository->updateResultClassment($match, $nbBut1, $nbBut2);
                $this->addFlash('success', "resultat effecturer avec succée <ul><li>mise à jour de resultat de match</li> <li>mise à jour de classment</li></ul>");
                return $this->redirectToRoute('app_matchs_index');
            }
        } else {

            if ($match->getNbBut1() != -1 && $match->getNbBut2() != -1) {
                $form->get('nbBut1')->setData(($match->getNbBut1()));
                $form->get('nbBut2')->setData(($match->getNbBut2()));
//
            }
        }

        return $this->render('matchs/update_result_form.html.twig', [
            'form' => $form->createView(),
            'match' => $match
        ]);
    }


}

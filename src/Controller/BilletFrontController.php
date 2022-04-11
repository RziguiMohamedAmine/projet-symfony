<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Repository\BilletRepository;
use App\Repository\MatchsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front/billet")
 */
class BilletFrontController extends AbstractController
{
    /**
     * @Route("/mesbillet", name="app_billet_front_mes_billet", methods={"get"})
     */
    public function mesBillet(MatchsRepository $matchsRepository, BilletRepository $billetRepository): Response
    {

        return $this->render('billet_front/mes_billet.html.twig', [
            'billets' => $billetRepository->findAll()
        ]);
    }

    /**
     * @Route("/", name="app_billet_front")
     */
    public function index(MatchsRepository $matchsRepository): Response
    {
        return $this->render('billet_front/index.html.twig', [
            'matchs' => $matchsRepository->getNextMatchs(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_billet_front_reservation", methods={"GET"})
     * @Route("/{id}/{bloc}", name="app_billet_front_bloc", methods={"GET"})
     */
    public function bloc(): Response
    {
        return $this->render('billet_front/choose_bloc.html.twig', [
        ]);
    }

    /**
     * @Route("/{id}/{bloc}", name="app_billet_front_bloc_post", methods={"POST"})
     */
    public function postBloc(MatchsRepository $matchsRepository, BilletRepository $billetRepository, $id, $bloc): Response
    {

        $billet = new Billet();
        $billet->setBloc($bloc);
        $billet->setIdMatch($matchsRepository->find($id));
        if ($bloc == 'A') {
            $billet->setPrix(35);

        } elseif ($bloc == 'B') {
            $billet->setPrix(30);

        } elseif ($bloc == 'C') {
            $billet->setPrix(25);

        } elseif ($bloc == 'D') {
            $billet->setPrix(20);

        } elseif ($bloc == 'E') {
            $billet->setPrix(15);
        }
        $billetRepository->add($billet);
        return $this->redirectToRoute('app_billet_front_mes_billet');
    }


}

<?php

namespace App\Controller;

use App\Form\SaisonType;
use App\Repository\ClassementRepository;
use App\Repository\MatchsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front/matchs")
 **/
class MatchFrontController extends AbstractController
{
    /**
     * @Route("/", name="app_front_match")
     */
    public function index(MatchsRepository $matchsRepository, ClassementRepository $classementRepository, Request $request): Response
    {
        $todayMatchs = $matchsRepository->getTodayMatchs();
        $nextMatchs = $matchsRepository->getNextMatchs();
        $saisons = $classementRepository->getSaisons();

        $classment = $classementRepository->findBy(['saison' => $saisons[0]]);
        dump($saisons[0]);

        return $this->render('match_front/index.html.twig', [
            'todayMatchs' => $todayMatchs,
            'nextMatchs' => $nextMatchs,
            'classments' => $classment,
            'saisons' => $saisons
        ]);
    }

    /**
     * @Route("/{saison}", name="app_front_match_saison")
     */
    public function indexSaison(MatchsRepository $matchsRepository, ClassementRepository $classementRepository, Request $request, $saison): Response
    {
        $nextMatchs = $matchsRepository->findBy(['saison' => $saison]);
        $todayMatchs = $matchsRepository->findBy(['saison' => $saison]);
        $classment = $classementRepository->findBy(['saison' => $saison]);
        dump($classment);
        $saisons = $classementRepository->getSaisons();
        return $this->render('match_front/index.html.twig', [
            'todayMatchs' => $todayMatchs,
            'nextMatchs' => $nextMatchs,
            'classments' => $classment,
            'saisons' => $saisons
        ]);
    }
}

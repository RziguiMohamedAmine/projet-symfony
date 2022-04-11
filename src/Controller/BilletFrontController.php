<?php

namespace App\Controller;

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
     * @Route("/", name="app_billet_front")
     */
    public function index(MatchsRepository $matchsRepository): Response
    {
        return $this->render('billet_front/index.html.twig', [
            'matchs' => $matchsRepository->getNextMatchs(),
        ]);
    }


}

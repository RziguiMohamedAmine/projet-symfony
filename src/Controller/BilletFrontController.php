<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Repository\BilletRepository;
use App\Repository\MatchsRepository;
use App\Repository\UserRepository;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * @Route("/front/billet")
 */
class BilletFrontController extends AbstractController
{
    /**
     * @Route("/mesbillet", name="app_billet_front_mes_billet", methods={"get"})
     */
    public function mesBillet(BilletRepository $billetRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find(61);
        $validBillet = $billetRepository->getValidBillet(61);
        $invalidBillet = $billetRepository->getInvalidBillet(61);

        return $this->render('billet_front/mes_billet.html.twig', [
            'validBillets' => $validBillet,
            'invalidBillet' => $invalidBillet,
        ]);
    }

    /**
     * @Route("/", name="app_billet_front")
     */
    public function index(MatchsRepository $matchsRepository): Response
    {
        return $this->render('billet_front/index.html.twig', [
            'matchs' => $matchsRepository->getMatchsAndBilletNumber(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_billet_front_reservation", methods={"GET"})
     * @Route("/{id}/{bloc}", name="app_billet_front_bloc", methods={"GET"})
     */
    public function bloc($id, MatchsRepository $matchsRepository): Response
    {

        return $this->render('billet_front/choose_bloc.html.twig', [
            'match' => $matchsRepository->find($id)
        ]);
    }

    /**
     * @Route("/{id}/{bloc}", name="app_billet_front_bloc_post", methods={"POST"})
     */
    public function postBloc(MatchsRepository $matchsRepository, BilletRepository $billetRepository, UserRepository $userRepository, $id, $bloc): Response
    {

        $billet = new Billet();
        $billet->setBloc($bloc);
        $billet->setIdMatch($matchsRepository->find($id));
        $billet->setIdUser($userRepository->find(61));
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
        if ($billetRepository->BilletDisponible($id))
            $billetRepository->add($billet);
        else {
            $this->addFlash('fail', 'billet non encore disponible');
            return $this->redirectToRoute('app_billet_front');
        }
        Stripe::setApiKey('sk_test_51HnVLcL83IQ8H8DrwhPGzj69I35Pj4kT5Ha3L0OiU2V3Rq3yatCybhyndI09PRuezGocFKvQPTjSE0TbmxTpxKKJ00duZqdBmt');
        $equipe1 = $billet->getIdMatch()->getEquipe1();
        $equipe2 = $billet->getIdMatch()->getEquipe2();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => "Billet Match $equipe1 - $equipe2",
                        ],
                        'unit_amount' => $billet->getPrix() * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_billet_front_mes_billet', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_billet_front', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }


}

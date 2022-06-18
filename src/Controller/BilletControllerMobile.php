<?php


namespace App\Controller;

use App\Entity\Billet;
use App\Form\BilletType;
use App\Repository\BilletRepository;
use App\Repository\MatchsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/mobile/billet")
 */
class BilletControllerMobile extends AbstractController
{

    /**
     * @Route("/mesbillet", name="app_mobile_billet_front_mes_billet", methods={"GET"})
     */
    public function mesBillet(Request $request, BilletRepository $billetRepository, NormalizerInterface $normalizable): Response
    {
        $validBillet = $billetRepository->getValidBillet($request->get('idUser'));
        $invalidBillet = $billetRepository->getInvalidBillet($request->get('idUser'));

        $result = [
            'validBillets' => $validBillet,
            'invalidBillet' => $invalidBillet,
        ];

        $jsonContent = $normalizable->normalize($result, 'json');

        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/", name="app_mobile_billet_front")
     */
    public function index(MatchsRepository $matchsRepository, NormalizerInterface $normalizable): Response
    {
        $jsonContent = $normalizable->normalize($matchsRepository->getMatchsWithBilletApp(), 'json');
        return new JsonResponse($jsonContent);

    }


    /**
     * @Route("/new", name="app_mobile_billet_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BilletRepository $billetRepository, MatchsRepository $matchsRepository, UserRepository $userRepository): Response
    {
        $billet = new Billet();
        $billet->setIdMatch($matchsRepository->find($request->get('idMatch')));
        $billet->setBloc($request->get('bloc'));
        $billet->setIdUser($userRepository->find($request->get('idUser')));

        $availble_billet = $billet->getIdMatch()->getNbSpectateur() - $billet->getIdMatch()->nbBillet;
        if ($availble_billet <= 0) {
            return new Response('pas de billet',
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/html']);
        } else {


            if ($billet->getBloc() == 'A') {
                $billet->setPrix(30);
            } elseif ($billet->getBloc() == 'B') {
                $billet->setPrix(25);
            } elseif ($billet->getBloc() == 'C') {
                $billet->setPrix(20);
            } elseif ($billet->getBloc() == 'D') {
                $billet->setPrix(15);
            }
            $billetRepository->add($billet);
            $this->addFlash('success', 'billet ajout success');

            return new Response('billet ajout success', Response::HTTP_OK);
        }
    }

    /**
     * @Route("/delete/{id}", name="app_mobile_billet_delete", methods={"GET"})
     */
    public function delete(Request $request, Billet $billet, BilletRepository $billetRepository): Response
    {
        $billetRepository->remove($billet);


        return new Response("billet Suprimée avec succée", Response::HTTP_OK);

    }


}

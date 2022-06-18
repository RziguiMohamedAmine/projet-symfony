<?php

namespace App\Controller;

use App\Entity\Matchs;
use App\Repository\ArbitreRepository;
use App\Repository\ClassementRepository;
use App\Repository\EquipeRepository;
use App\Repository\MatchsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/mobile/matchs")
 **/
class MatchControllerMobile extends AbstractController
{
    /**
     * @Route("/front", name="app_mobile_front_match")
     */
    public function index(MatchsRepository $matchsRepository, ClassementRepository $classementRepository, NormalizerInterface $normalizable): Response
    {
        $todayMatchs = $matchsRepository->getTodayMatchs();
        $nextMatchs = $matchsRepository->getNextMatchs();
        $saisons = $classementRepository->getSaisons();

        $matchHistory = $matchsRepository->getMatchHistory($saisons[0]['saison']);

        $classment = $classementRepository->findBy(['saison' => $saisons[0]], ['nbPoint' => 'DESC']);
        $result = [
            'todayMatchs' => $todayMatchs,
            'nextMatchs' => $nextMatchs,
            'matchHistory' => $matchHistory,
            'classments' => $classment,
            'saisons' => $saisons,
            'currentSaison' => null

        ];
        $jsonContent = $normalizable->normalize($result, 'json');

        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/front/{saison}", name="app_mobole_front_match_saison")
     */
    public function indexSaison(MatchsRepository $matchsRepository, ClassementRepository $classementRepository, NormalizerInterface $normalizer, $saison): Response
    {
        $todayMatchs = $matchsRepository->findBy(['saison' => $saison], ['date' => 'DESC']);
        $classment = $classementRepository->findBy(['saison' => $saison]);
        $saisons = $classementRepository->getSaisons();
        $result = [
            'todayMatchs' => $todayMatchs,
            'nextMatchs' => [],
            'classments' => $classment,
            'saisons' => $saisons,
            'currentSaison' => $saison
        ];
        $jsonContent = $normalizer->normalize($result, 'json');

        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/back", name="app_mobile_matchs_index", methods={"GET"})
     */
    public function index2(MatchsRepository $matchsRepository, NormalizerInterface $normalizer): Response
    {
        $matchs = $matchsRepository->findAll();
        $jsonContent = $normalizer->normalize($matchs, 'json');
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/new", name="app_mobile_matchs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MatchsRepository $matchsRepository, EquipeRepository $equipeRepository, ArbitreRepository $arbitreRepository): Response
    {
        $match = new Matchs();
        $match->setSaison($request->get("saison"));
        $match->setNbBut2($request->get("nbBut2"));
        $match->setNbBut1($request->get("nbBut1"));
        $match->setRound($request->get("round"));
        $match->setStade($request->get("stade"));

        $match->setNbSpectateur($request->get("nbSpectateur"));
        $match->setEquipe1($equipeRepository->find($request->get("equipe1")));
        $match->setEquipe2($equipeRepository->find($request->get("equipe2")));
        $match->setIdArbitre1($arbitreRepository->find($request->get("arbitre1")));
        $match->setIdArbitre2($arbitreRepository->find($request->get("arbite2")));
        $match->setIdArbitre3($arbitreRepository->find($request->get("arbite3")));
        $match->setIdArbitre4($arbitreRepository->find($request->get("arbite4")));

        $now = new DateTime();
        $mil = $request->get('date');
        $seconds = $mil / 1000;

        $dateMatch = date_create_from_format("d-m-Y h:i:s", date("d-m-Y h:i:s", $seconds));
        $match->setDate($dateMatch);

        if ($dateMatch < $now) {
            return new Response('date doit etre au future',
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/html']);
        }
        if ($matchsRepository->haveMatch($match->getEquipe1(), $match->getDate()) == []) {
            if ($matchsRepository->haveMatch($match->getEquipe2(), $match->getDate()) == []) {
                $match->setSaison(str_replace("/", "", $match->getSaison()));
                $matchsRepository->add($match);
                $this->addFlash('success', 'match ajoutée avec succées');
                return new Response('match ajoutée avec succées', Response::HTTP_OK);
            } else {
                return new Response($match->getEquipe2() . ' a un match pour ' . $match->getDate()->format('d-m-y'), Response::HTTP_BAD_REQUEST);

            }

        } else {
            return new Response($match->getEquipe1() . ' a un match pour ' . $match->getDate()->format('d-m-y'), Response::HTTP_BAD_REQUEST);
        }


    }

    /**
     * @Route("/{id}", name="app_mobile_matchs_show", methods={"GET"})
     */
    public function show($id, NormalizerInterface $normalizer, MatchsRepository $matchsRepository): Response
    {
        $match = $matchsRepository->find($id);
        $jsonContent = $normalizer->normalize($match, "json");
        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/{id}/edit", name="app_mobile_matchs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MatchsRepository $matchsRepository, $id): Response
    {
        $match = new Matchs();
        $match->setId($id);
        $match->setSaison($request->get("saison"));
        $match->setNbBut2($request->get("nbBut2"));
        $match->setNbBut1($request->get("nbBut1"));
        $match->setRound($request->get("round"));
        $match->setStade($request->get("stade"));
        $match->setDate($request->get("date"));
        $match->setNbSpectateur(10000);
        $match->setEquipe1($request->get("equipe1"));
        $match->setEquipe2($request->get("equipe2"));
        $match->setIdArbitre1($request->get("arbitre1"));
        $match->setIdArbitre2($request->get("arbite2"));
        $match->setIdArbitre3($request->get("arbite3"));
        $match->setIdArbitre4($request->get("arbite4"));

        $match->setSaison(substr($match->getSaison(), 0, 4) . '/' . substr($match->getSaison(), 4));
        $match->setSaison(str_replace("/", "", $match->getSaison()));
        $matchsRepository->add($match);
        $this->addFlash('success', 'match changer avec succée');
        return $this->redirectToRoute('app_matchs_index', [], Response::HTTP_SEE_OTHER);


    }
//

    /**
     *
     * @Route("/delete/{id}", name="app_mobile_matchs_delete", methods={"GET"})
     */
    public function delete(Request $request, Matchs $match, MatchsRepository $matchsRepository): Response
    {
        $matchsRepository->remove($match);
        return new Response("match Suprimée avec succée", Response::HTTP_OK);
    }
//

    /**
     * @Route("/tirageausort/test", name="app_mobile_matchs_tirage_au_sort",methods={"GET"} )
     */
    public function tirageAuSort(Request $request, MatchsRepository $matchsRepository): Response
    {

        $saison = $request->get("saison");

        $saison = str_replace("/", "", $saison);
        $mil = $request->get('date');
        $seconds = $mil / 1000;

        $date = date_create_from_format("d-m-Y h:i:s", date("d-m-Y h:i:s", $seconds));
        $result = $matchsRepository->trigeausort($saison, $date);
        if ($result == "true") {
            return new Response('Tirage Au Sort de saison' . $saison . ' effectuée avec succée \n création des matchs \n création de table de classment', Response::HTTP_OK);
        } else {
            return new Response($result, Response::HTTP_BAD_REQUEST);
        }

    }

}

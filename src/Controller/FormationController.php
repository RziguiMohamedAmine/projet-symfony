<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Joueur;
use App\Form\FormationType;
use App\Repository\EquipeRepository;
use App\Repository\FormationRepository;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("back/", name="app_formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back/new/{id}", name="app_formation_new", methods={"GET", "POST"})
     */
    public function new(Request $request,EquipeRepository $equipeRepository, FormationRepository $formationRepository,$id): Response
    {
        $equipe=$equipeRepository->find($id);
        $formation = new Formation();

        $form = $this->createFormBuilder($formation)
            ->add('poste',ChoiceType::class, [
                'choices'  => [
                    'gardien(gk)' => 'gardien',
                    'defenseur(cb)' => 'defenseur',
                    'milieu(rmf)' => 'milieu',
                    'attaquant(cf)' => 'attaquant',
                ],
            ])
            ->add('idJoueur',EntityType::class, [
                'class' => Joueur::class,
                'query_builder' => function (EntityRepository $er)use ($equipe) {
                    return $er->createQueryBuilder('j')
                        ->join('j.idEquipe','e')
                        ->addSelect('e')
                        ->where('e.id=:id')
                        ->orderBy('j.poste','asc')
                        ->setParameter('id',$equipe->getId());
                },
                'choice_label' => 'nom','label'=>'Joueur'
            ])
            ->getForm();
        //$form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationRepository->add($formation);
            return $this->redirectToRoute('app_equipe_indform', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_formation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Formation $formation, FormationRepository $formationRepository): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationRepository->add($formation);
            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param JoueurRepository $equipeRepository
     * @param FormationRepository $joueurRepository
     * @param $id
     * @return Response
     * @Route("/admin/{id}", name="app_formation_delete",  methods={"GET", "POST"})
     */

    public function delete(JoueurRepository $equipeRepository,FormationRepository $formationRepository,$id): Response
    {

        $equipe = $equipeRepository->find($id);
        $formationRepository->deleteform($equipe->getId());
        return $this->redirectToRoute('app_equipe_indform', [], Response::HTTP_SEE_OTHER);

    }

    /*
    public function delete(Request $request, Formation $formation, FormationRepository $formationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $formationRepository->remove($formation);
        }

        return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
    }
*/

    /**
     * @param EquipeRepository $equipeRepository
     * @param FormationRepository $joueurRepository
     * @param $id
     * @return Response
     * @Route("/back/formm/{id}", name="app_formation_indexfor", methods={"GET", "POST"})
     */
    public function indexfor(EquipeRepository $equipeRepository,FormationRepository $formationRepository,$id): Response
    {

        $equipe = $equipeRepository->find($id);
        $formations=$formationRepository->formationEquipe($equipe->getId());
        return $this->render('formation/index.html.twig',[
            'e'=>$equipe,'formations'=>$formations
        ]);

    }
}

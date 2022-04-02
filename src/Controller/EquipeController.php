<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use App\Repository\JoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipe")
 */
class EquipeController extends AbstractController
{
    /**
     * @Route("/admin/", name="app_equipe_index", methods={"GET"})
     */
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipeRepository->findAll(),
        ]);
    }


    /**
     * @Route("/client/", name="app_equipe_indexFront", methods={"GET"})
     */
    public function indexFront(EquipeRepository $equipeRepository): Response
    {
        return $this->render('equipe/indexFront.html.twig', [
            'equipes' => $equipeRepository->findAll(),
        ]);
    }


    /**
     * @Route("/admin/new", name="app_equipe_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EquipeRepository $equipeRepository/*,SluggerInterface $slugger*/): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file=pathinfo($form['logo']->getData()->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $file.'-'.uniqid().'.'.$form['logo']->getData()->guessExtension();

            try {
                $form['logo']->getData()->move(
                    $this->getParameter('logo_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $equipe->setLogo($newFilename);
            $equipeRepository->add($equipe);
            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="app_equipe_show", methods={"GET"})
     */
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="app_equipe_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Equipe $equipe, EquipeRepository $equipeRepository): Response
    {
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=pathinfo($form['logo']->getData()->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $file.'-'.uniqid().'.'.$form['logo']->getData()->guessExtension();
            try {
                $form['logo']->getData()->move(
                    $this->getParameter('logo_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $equipe->setLogo($newFilename);
            $equipeRepository->add($equipe);
            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="app_equipe_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipe $equipe, EquipeRepository $equipeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getId(), $request->request->get('_token'))) {
            $equipeRepository->remove($equipe);
        }

        return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param EquipeRepository $equipeRepository
     * @param JoueurRepository $joueurRepository
     * @param $id
     * @return Response
     *  @Route("/front/{id}", name="app_equipe_joueur", methods={"GET", "POST"})
     */
    function ListJoueurByEquipe(EquipeRepository $equipeRepository,JoueurRepository $joueurRepository,$id)
    {
        $equipe = $equipeRepository->find($id);
        $joueur=$joueurRepository->listJoueur($equipe->getId());
        return $this->render("Joueur/indexFront.html.twig",[
            'e'=>$equipe,'joueur'=>$joueur
        ]);
    }

    /**
     * @param EquipeRepository $equipeRepository
     * @param JoueurRepository $joueurRepository
     * @param $id
     * @return Response
     *  @Route("/back/{id}", name="app_equipe_joueur_back", methods={"GET", "POST"})
     */
    function ListJoueurByEquipeback(EquipeRepository $equipeRepository,JoueurRepository $joueurRepository,$id)
    {
        $equipe = $equipeRepository->find($id);
        $joueur=$joueurRepository->listJoueur($equipe->getId());
        return $this->render("Joueur/joueurEquipe.html.twig",[
            'e'=>$equipe,'joueur'=>$joueur
        ]);
    }


}

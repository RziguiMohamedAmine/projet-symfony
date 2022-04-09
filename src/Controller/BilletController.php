<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Form\BilletType;
use App\Repository\BilletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/billet")
 */
class BilletController extends AbstractController
{
    /**
     * @Route("/", name="app_billet_index", methods={"GET"})
     */
    public function index(BilletRepository $billetRepository): Response
    {
        return $this->render('billet/index.html.twig', [
            'billets' => $billetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_billet_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BilletRepository $billetRepository): Response
    {
        $billet = new Billet();
        $form = $this->createForm(BilletType::class, $billet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('billet/new.html.twig', [
            'billet' => $billet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_billet_show", methods={"GET"})
     */
    public function show(Billet $billet): Response
    {
        return $this->render('billet/show.html.twig', [
            'billet' => $billet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_billet_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Billet $billet, BilletRepository $billetRepository): Response
    {
        $form = $this->createForm(BilletType::class, $billet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $billetRepository->add($billet);
            return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('billet/edit.html.twig', [
            'billet' => $billet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_billet_delete", methods={"POST"})
     */
    public function delete(Request $request, Billet $billet, BilletRepository $billetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $billet->getId(), $request->request->get('_token'))) {
            $billetRepository->remove($billet);
        }

        return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
    }
}

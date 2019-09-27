<?php

namespace App\Controller;

use App\Entity\Studio;
use App\Form\StudioType;
use App\Repository\StudioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/studio")
 */
class StudioController extends AbstractController
{
    /**
     * @Route("/", name="studio_index", methods={"GET"})
     * @param StudioRepository $studioRepository
     * @return Response
     */
    public function index(StudioRepository $studioRepository): Response
    {
        return $this->render('studio/index.html.twig', [
            'studios' => $studioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="studio_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $studio = new Studio();
        $form = $this->createForm(StudioType::class, $studio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($studio);
            $entityManager->flush();

            return $this->redirectToRoute('studio_index');
        }

        return $this->render('studio/new.html.twig', [
            'studio' => $studio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="studio_show", methods={"GET"})
     * @param Studio $studio
     * @return Response
     */
    public function show(Studio $studio): Response
    {
        return $this->render('studio/show.html.twig', [
            'studio' => $studio,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="studio_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Studio $studio
     * @return Response
     */
    public function edit(Request $request, Studio $studio): Response
    {
        $form = $this->createForm(StudioType::class, $studio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('studio_index', [
                'id' => $studio->getId(),
            ]);
        }

        return $this->render('studio/edit.html.twig', [
            'studio' => $studio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="studio_delete", methods={"DELETE"})
     * @param Request $request
     * @param Studio $studio
     * @return Response
     */
    public function delete(Request $request, Studio $studio): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studio->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($studio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('studio_index');
    }
}

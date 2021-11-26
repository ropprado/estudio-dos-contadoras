<?php

namespace App\Controller\Admin;

use App\Entity\Etiqueta;
use App\Form\EtiquetaType;
use App\Repository\EtiquetaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/etiqueta")
 */
class EtiquetaController extends AbstractController
{
    /**
     * @Route("/", name="admin_etiqueta_index", methods={"GET"})
     */
    public function index(EtiquetaRepository $etiquetaRepository): Response
    {
        return $this->render('admin/etiqueta/index.html.twig', [
            'etiquetas' => $etiquetaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_etiqueta_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etiqueta = new Etiqueta();
        $form = $this->createForm(EtiquetaType::class, $etiqueta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etiqueta);
            $entityManager->flush();

            return $this->redirectToRoute('admin_etiqueta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/etiqueta/new.html.twig', [
            'etiqueta' => $etiqueta,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_etiqueta_show", methods={"GET"})
     */
    public function show(Etiqueta $etiqueta): Response
    {
        return $this->render('admin/etiqueta/show.html.twig', [
            'etiqueta' => $etiqueta,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_etiqueta_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etiqueta $etiqueta): Response
    {
        $form = $this->createForm(EtiquetaType::class, $etiqueta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_etiqueta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/etiqueta/edit.html.twig', [
            'etiqueta' => $etiqueta,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_etiqueta_delete", methods={"POST"})
     */
    public function delete(Request $request, Etiqueta $etiqueta): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etiqueta->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etiqueta);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_etiqueta_index', [], Response::HTTP_SEE_OTHER);
    }
}

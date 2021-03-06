<?php

namespace App\Controller\Admin;

use App\Entity\Entrada;
use App\Form\EntradaType;
use App\Repository\EntradaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/entrada")
 */
class EntradaController extends AbstractController
{
    /**
     * @Route("/", name="admin_entrada_index", methods={"GET"})
     */
    public function index(EntradaRepository $entradaRepository): Response
    {   
        $entrada = $entradaRepository->findAll();

        return $this->render('admin/entrada/index.html.twig', [
            'entradas' => $entrada,
        ]);
    }

    /**
     * @Route("/new", name="admin_entrada_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entrada = new Entrada();
        $form = $this->createForm(EntradaType::class, $entrada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entrada->setFecha (new \DateTime() );

            $entityManager->persist($entrada);
            $entityManager->flush();

            return $this->redirectToRoute('admin_entrada_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/entrada/new.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_entrada_show", methods={"GET"})
     */
    public function show(Entrada $entrada): Response
    {
        return $this->render('admin/entrada/show.html.twig', [
            'entrada' => $entrada,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_entrada_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrada $entrada): Response
    {
        $form = $this->createForm(EntradaType::class, $entrada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_entrada_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('admin/entrada/edit.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_entrada_delete", methods={"POST"})
     */
    public function delete(Request $request, Entrada $entrada): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrada->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrada);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_entrada_index', [], Response::HTTP_SEE_OTHER);
    }
}

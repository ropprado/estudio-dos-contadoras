<?php

namespace App\Controller\Admin;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categoria")
 */
class CategoriaController extends AbstractController
{
    /**
     * @Route("/", name="admin_categoria_index", methods={"GET"})
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('admin/categoria/index.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_categoria_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('admin_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categoria/new.html.twig', [
            'categoria' => $categoria,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_categoria_show", methods={"GET"})
     */
    public function show(Categoria $categoria): Response
    {
        return $this->render('admin/categoria/show.html.twig', [
            'categoria' => $categoria,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_categoria_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categoria $categoria): Response
    {
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categoria/edit.html.twig', [
            'categoria' => $categoria,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_categoria_delete", methods={"POST"})
     */
    public function delete(Request $request, Categoria $categoria): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoria->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoria);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_categoria_index', [], Response::HTTP_SEE_OTHER);
    }
}

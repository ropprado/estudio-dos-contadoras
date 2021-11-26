<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entrada;
use App\Entity\Etiqueta;
use App\Entity\Categoria;


use App\Repository\EntradaRepository;
use App\Repository\CategoriaRepository;
use App\Repository\EtiquetaRepository;

class BlogController extends AbstractController
{

    private $repoCat;
    private $repoEtiq;

    public function __construct(EtiquetaRepository $re, CategoriaRepository $rc){
        $this->repoCat = $rc;
        $this->repoEtiq = $re;
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index( Request $request, EntradaRepository $repo): Response
    {   
        $idCategoria = $request->query->get('cat');
        if(empty($idCategoria)){
            $idCategoria = 0;
        }
        $categoria = $this->repoCat->find($idCategoria);

        $idEtiqueta = $request->query->get('etiq');
        if(empty($idEtiqueta) ){
            $idEtiqueta = 0;
        }
        $etiqueta = $this->repoEtiq->find($idEtiqueta);
 
        $entrada = $repo->findByFilter($categoria,$etiqueta);

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'categorias' => $this->repoCat->findAll(),
            'etiquetas' => $this->repoEtiq->findAll(),
            'entradas' => $entrada,
            'filtro' => [ 'cat'=>$idCategoria, 'etiq'=>$idEtiqueta ],
            'bloglist' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/blog/{id}", name="singleblog")
     */
    public function getDetail(Request $request, Entrada $entrada): Response
    {   
        $idCategoria = $request->query->get('cat');
        if(empty($idCategoria)){
            $idCategoria = 0;
        }
        $categoria = $this->repoCat->find($idCategoria);

        $idEtiqueta = $request->query->get('etiq');
        if(empty($idEtiqueta) ){
            $idEtiqueta = 0;
        }
        $etiqueta = $this->repoEtiq->find($idEtiqueta);

        return $this->render('blog/singleblog.html.twig', [
            'entrada' => $entrada,
            'categorias' => $this->repoCat->findAll(),
            'etiquetas' => $this->repoEtiq->findAll(),
            'entradas' => $entrada,
            'filtro' => [ 'cat'=>$idCategoria, 'etiq'=>$idEtiqueta ],
        ]);
    }
}

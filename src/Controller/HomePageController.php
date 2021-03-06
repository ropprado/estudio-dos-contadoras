<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/about", name="about_page")
     */
    public function showAbout(): Response
    {
        return $this->render('home_page/about.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

     /**
     * @Route("/services", name="services_page")
     */
    public function showServices(): Response
    {
        return $this->render('home_page/services.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}

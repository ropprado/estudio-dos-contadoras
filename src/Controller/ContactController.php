<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {   
        $contacto = new Contact();
        $form = $this->createForm(ContactFormType::class, $contacto);
        $form->handleRequest($request);
        
        if($form->isSubmitted() AND $form->isValid() ){
            $mensaje = (new \Swift_Message())
                ->setSubject('Contacto')
                ->setFrom([$contacto->getEmail() => $contacto->getEmail(), 'estudio.doscontadoras@gmail.com'=> 'Contacto'])
                ->setReplyTo([$contacto->getEmail() => $contacto->getNombre()])
                ->setTo(['estudio.doscontadoras@gmail.com'])
                ->setBody(
                    $this->renderView('contact/contact.mail.html.twig',[
                        'contact' => $contacto
                    ]),
                    'text/html'
                )
                ->addPart(
                    'text/plain'
            );
            $mailer->send($mensaje);
            return $this->redirectToRoute('home_page');
        } 
        return $this->render('contact/index.html.twig', [
            'contact' => $contacto,
            'formulario'    => $form->createView()
        ]);
    }
}

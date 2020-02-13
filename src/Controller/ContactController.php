<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Events\ContactFormSubmittedEvent;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", methods="GET|POST", name="contact")
     */
    public function contactNew(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        //создаем объект Contact
        $contact = new Contact();
        //создаем форму
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //сохраняем в базу
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            //оповещаем клиента
            $this->addFlash('success', 'Успешно отправлено');
            //событие произошло
            $eventDispatcher->dispatch(new ContactFormSubmittedEvent($contact));

            //$this->redirect('contact');
            //return $this->redirectToRoute('contact_thanks');
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contact-thanks", methods="GET", name="contact_thanks")
     */
    public function contactThanks()
    {
        return $this->render('contact/thanks.html.twig');
    }
}

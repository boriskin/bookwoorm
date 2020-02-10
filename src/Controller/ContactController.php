<?php

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
        //установим дата и время, т.к. на форме их нет
        $contact->setPublishedAt(new \DateTime('now'));
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

            //редирект
            //return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

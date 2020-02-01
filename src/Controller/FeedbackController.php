<?php

namespace App\Controller;

use App\Form\FeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class FeedbackController extends AbstractController
{
    /**
     * @Route("/feedback", name="feedback")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form=$this->createForm(FeedbackType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $feedbackFormData = $form->getData();

            $message = (new \Swift_Message('Заголовок письма'))
                ->setFrom($feedbackFormData['from'])
                ->setTo('test@local')
                ->setBody(
                    $feedbackFormData['message'],
                    'text/plain'
                )
            ;

            $mailer->send($message);

            $this->addFlash(
                'success',
                'Успешно отправлено!');

            return $this->redirectToRoute('feedback');
        }

        return $this->render('feedback/index.html.twig', [
            'feedback_form'=>$form->createView(),
        ]);
    }
}

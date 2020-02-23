<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\EventSubscriber;

use App\Events\ContactFormSubmittedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactNotificationSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $senderEmail;
    private $adminEmail;

    public function __construct(MailerInterface $mailer, $senderEmail, $adminEmail)
    {
        $this->mailer = $mailer;
        $this->senderEmail = $senderEmail;
        $this->adminEmail = $adminEmail;
    }

    public function onContactSubmittedEvent(ContactFormSubmittedEvent $event): void
    {
        $contact = $event->getContact();

        $email = (new Email())
            ->from($this->senderEmail)
            //пока не капчи не буду на из формы отправлять, только админу
            //->to($contact->getEmail())
            ->to($this->adminEmail)
            //->bcc($this->adminEmail)
            ->subject('Обратная связь')
            ->html('Привет, ' . $contact->getName() . '('.$contact->getEmail(). ')  ! Спасибо за внимание.')
        ;

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents()
    {
        return [
            ContactFormSubmittedEvent::class => 'onContactSubmittedEvent',
        ];
    }
}

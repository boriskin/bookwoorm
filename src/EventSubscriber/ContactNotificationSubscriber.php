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
            ->to($contact->getEmail())
            ->subject('Обратная связь bookwoorm')
            ->html('Привет, ' . $contact->getName() . '! Спасибо Вам огромное, что уделили время и оставили обратную связь.')
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

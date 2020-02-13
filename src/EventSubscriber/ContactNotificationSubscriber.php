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

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onContactSubmittedEvent(ContactFormSubmittedEvent $event): void
    {
        //TODO: Янедекс прикрутить и переменные from/to вынести в файл.env
        $email = (new Email())
            ->from('from@aa.aa')
            ->to('to@bb.bb')
            ->subject('Тема')
            ->html('Тело сообщения')
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

<?php

namespace App\EventSubscriber;

use App\Entity\Contact;
use App\Events\ContactFormSubmittedEvent;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactNotificationSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $logger;

    public function __construct(MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
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
        $this->logger->log(LogLevel::INFO, 'Контакт создан успешно');
    }

    public static function getSubscribedEvents()
    {
        return [
            ContactFormSubmittedEvent::class => 'onContactSubmittedEvent',
        ];
    }
}

<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\EventListener;

use App\Entity\Contact;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ContactCreateListener
{
    public function prePersist(Contact $contact, LifecycleEventArgs $event)
    {
        //перед сохранением сущности Contact установим свойство publishedAt
        $contact->setPublishedAt(new \DateTime('now'));
    }
}

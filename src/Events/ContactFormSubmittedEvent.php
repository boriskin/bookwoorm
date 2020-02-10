<?php

namespace App\Events;

use App\Entity\Contact;
use Symfony\Contracts\EventDispatcher\Event;

class ContactFormSubmittedEvent extends Event
{
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        //установим дата и время, т.к. на форме их нет
        //$contact->setPublishedAt(new \DateTime('now'));
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}


<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Tests\Form\Type;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class ContactTypeTest extends TypeTestCase
{
    protected function getExtensions()
    {
        $validator = Validation::createValidator();

        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testSubmitValidData()
    {
        $formData = [
            'name' => 'name',
            'email' => 'email@host',
            'message' => '1234567890123456789',
        ];

        $objectToCompare = new Contact();
        $form = $this->factory->create(ContactType::class, $objectToCompare);

        $object = new Contact();
        $object
            ->setName($formData['name'])
            ->setEmail($formData['email'])
            ->setMessage($formData['message']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertSame($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}

<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Form;

use App\Entity\Contact;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Ваше имя',
            ])
            ->add('email')
            ->add('message', null, [
                'label' => 'Сообщение',
            ])
            ->add('recaptcha', EWZRecaptchaType::class, [
                'label' => false,
                'language' => 'ru',
                'attr' => [
                    'options' => [
                        'theme' => 'light',
                        'type' => 'image',
                        'size' => 'small',
                    ],
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить',
                'attr' => ['class' => 'btn btn-bookwoorm'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

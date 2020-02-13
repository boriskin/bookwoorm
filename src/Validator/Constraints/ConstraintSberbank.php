<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintSberbank extends Constraint
{
    public $message = 'Адрес "{{ string }}" запрещен: принадлежит Сбербанк!';
}

<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintSberbank extends Constraint
{
    public $message = 'Адрес "{{ string }}" запрещен: принадлежит Сбербанк!';
}

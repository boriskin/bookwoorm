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
class ConstraintsEmail extends Constraint
{
    public $invalidMessage = 'Адрес "{{ value }}" сомнительный!';
    public $banMessage = 'Адрес "{{ value }}" заблокирован!';
}

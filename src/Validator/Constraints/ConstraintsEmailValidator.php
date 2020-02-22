<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Validator\Constraints;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ConstraintsEmailValidator extends ConstraintValidator
{
    private $validator;
    private $multipleValidations;

    public function __construct()
    {
        $this->validator = new EmailValidator();
        $this->multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation(),
            new SpoofCheckValidation(),
        ]);
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ConstraintsEmail) {
            throw new UnexpectedTypeException($constraint, ConstraintsEmail::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!$this->validator->isValid($value, $this->multipleValidations)) {
            $this->context->buildViolation($constraint->invalidMessage)
                ->setParameter('{{ value }}', $value)
                ->addViolation();

            return;
        }

        //TODO выделить в Utils
        $ban = [
            'pochta.ru',
            'sberbank.ru',
            'sbrf.ru',
        ];

        foreach ($ban as $item) {
            if (mb_strtolower(mb_substr($value, mb_strrpos($value, '@') + 1)) === $item) {
                $this->context->buildViolation($constraint->banMessage)
                    ->setParameter('{{ value }}', $value)
                    ->addViolation();

                return;
            }
        }
    }
}

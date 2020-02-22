<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Tests\Validator\Constraints;

use App\Validator\Constraints\ConstraintsEmail;
use App\Validator\Constraints\ConstraintsEmailValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @covers \App\Validator\Constraints\ConstraintsEmailValidator
 */
class ConstraintsEmailValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new ConstraintsEmailValidator();
    }

    /**
     * @dataProvider getValidData
     */
    public function testValidData($data)
    {
        $this->validator->validate($data, new ConstraintsEmail());
        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidData
     */
    public function testInvalidData($data)
    {
        $this->validator->validate($data, new ConstraintsEmail());
        $this
            ->buildViolation('Адрес "{{ value }}" сомнительный!')
            ->setParameter('{{ value }}', $data)
            ->assertRaised();
    }

    /**
     * @dataProvider getBanData
     */
    public function testBanData($data)
    {
        $this->validator->validate($data, new ConstraintsEmail());
        $this
            ->buildViolation('Адрес "{{ value }}" заблокирован!')
            ->setParameter('{{ value }}', $data)
            ->assertRaised();
    }

    public function getValidData()
    {
        yield ['valid1@yandex.ru'];
        yield ['valid2@google.com'];
        yield ['valid3@mail.ru'];
        yield ['valid4@ascc.team'];
    }

    public function getInvalidData()
    {
        yield ['invalid1'];
        yield ['invalid2@invalid2'];
        yield ['invalid3@.mail.ru'];
        yield ['invalid4@mail.ru.'];
        yield ['invalid5@mail@ru.ru'];
        yield ['invalid6@mail .ru'];
    }

    public function getBanData()
    {
        yield ['ban1@sberbank.ru'];
        yield ['ban2@sbrf.ru'];
        yield ['ban3@pochta.ru'];
    }
}

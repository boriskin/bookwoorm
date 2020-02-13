<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Entity;

use App\Validator\Constraints as SberbankAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Email(
     *     message = "Не является адресом электронной почты!",
     *     normalizer = "strtolower",
     *     mode = "strict"
     * )
     * @SberbankAssert\ConstraintSberbank()
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *     allowEmptyString = false,
     *     min = 10,
     *     max = 2000,
     *     minMessage = "Должно быть минимум {{ limit }} символов!",
     *     maxMessage = "Не может превышать {{ limit }} символов!"
     * )
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
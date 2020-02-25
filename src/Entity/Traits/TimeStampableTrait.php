<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Exception;

/**
 * Trait TimeStampableTrait.
 */
trait TimeStampableTrait
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @throws Exception
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt ?? new DateTime();
    }

    /**
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt ?? new DateTime();
    }

    /**
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(): void
    {
        $now = new DateTime();
        $this->setUpdatedAt($now);
        if (null === $this->getId()) {
            $this->setCreatedAt($now);
        }
    }
}

<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Book
{
    use TimeStampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $pages;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author", inversedBy="books")
     */
    private $author;

    public function __construct()
    {
        $this->author = new ArrayCollection();
    }

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

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(int $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        if ($this->author->contains($author)) {
            $this->author->removeElement($author);
        }

        return $this;
    }
}

<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadCategories($manager);
        $this->loadBooks($manager);
    }

    private function loadCategories(ObjectManager $manager): void
    {
        foreach ($this->getData() as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $this->addReference($name, $category);
        }

        $manager->flush();
    }

    private function loadBooks(ObjectManager $manager): void
    {
        for ($i = 0; $i < 200; ++$i) {
            $book = new Book();
            $book->setCategory($this->getReference($this->getData()[rand(0, 5)]));
            $book->setName('Книга '.$i);
            $book->setYear(rand(1900, 2020));
            $book->setPages(rand(10, 500));
            $book->setIsbn(rand(1, 100) * 10000000 + rand(1, 9));
            $manager->persist($book);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            'Фантастика',
            'Роман',
            'Наука',
            'Детектив',
            'Учебник',
            'test',
        ];
    }
}

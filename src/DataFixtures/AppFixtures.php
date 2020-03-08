<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
//use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //$this->LoadUsers($manager);
        $this->LoadAuthors($manager);
        $this->loadCategories($manager);
        $this->loadBooks($manager);
    }

//    private function loadUsers(ObjectManager $manager): void
//    {
//        $user = new User();
//        $user->setUsername('user');
//        $user->setEmail('user@bookwoorm.app');
//        $user->setPlainPassword('user');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_USER'));
//        $manager->persist($user);
//
//        $admin = new User();
//        $admin->setUsername('admin');
//        $admin->setEmail('admin@bookwoorm.app');
//        $admin->setPlainPassword('admin');
//        $admin->setEnabled(true);
//        $admin->setRoles(array('ROLE_SUPER_ADMIN'));
//        $manager->persist($admin);
//
//        $manager->flush();
//    }

    private function loadCategories(ObjectManager $manager): void
    {
        foreach ($this->getCategory() as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $this->addReference('cat-'.$name, $category);
        }

        $manager->flush();
    }

    private function LoadAuthors(ObjectManager $manager): void
    {
        foreach ($this->getAuthors() as $key => $item) {
            $author = new Author();
            $author->setFirstName($item['firstName']);
            $author->setMiddleName($item['middleName']);
            $author->setLastName($item['lastName']);
            $manager->persist($author);
            $this->addReference('author-'.$key, $author);
        }

        $manager->flush();
    }

    private function loadBooks(ObjectManager $manager): void
    {
        for ($i = 0; $i < 200; ++$i) {
            $book = new Book();
            $book->setCategory($this->getReference('cat-'.$this->getCategory()[rand(0, count($this->getCategory()) - 1)]));
            $book->setName('Книга '.$i);
            $book->setYear(rand(1900, 2020));
            $book->setPages(rand(10, 500));
            $book->setIsbn(rand(1, 100) * 10000000 + rand(1, 9));
            $book->addAuthor($this->getReference('author-'.rand(0, count($this->getAuthors()) - 1)));
            //добавим каждой 5 книге еще одного автора - Иванова Ивана Ивановича
            if (0 === ($i % 5)) {
                $book->addAuthor($this->getReference('author-0'));
            }
            $manager->persist($book);
        }

        $manager->flush();
    }

    private function getCategory(): array
    {
        return [
            'Фантастика',
            'Роман',
            'Наука',
            'Детектив',
            'Учебник',
            'Детская',
        ];
    }

    private function getAuthors(): array
    {
        return [
            [
                'firstName' => 'Иван',
                'middleName' => 'Иванович',
                'lastName' => 'Иванов',
            ],
            [
                'firstName' => 'Александр',
                'middleName' => 'Сергеевич',
                'lastName' => 'Пушкин',
            ],
            [
                'firstName' => 'Иван',
                'middleName' => 'Андреевич',
                'lastName' => 'Крылов',
            ],
            [
                'firstName' => 'Фёдор',
                'middleName' => 'Михайлович',
                'lastName' => 'Достоевский',
            ],
            [
                'firstName' => 'Иван',
                'middleName' => 'Сергеевич',
                'lastName' => 'Тургенев',
            ],
            [
                'firstName' => 'Марк',
                'middleName' => '',
                'lastName' => 'Твен',
            ],
            [
                'firstName' => 'Виктор',
                'middleName' => '',
                'lastName' => 'Гюго',
            ],
            [
                'firstName' => 'Жюль',
                'middleName' => '',
                'lastName' => 'Верн',
            ],
        ];
    }
}

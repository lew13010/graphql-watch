<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $author = (new Author())
                ->setName($faker->name())
                ->setBirthdate($faker->dateTime());

            $manager->persist($author);

            for ($j = 0; $j < random_int(1, 10); $j++) {
                $book = (new Book())
                    ->setTitle($faker->word)
                    ->setDescription($faker->sentence())
                    ->setIsbn($faker->isbn13())
                    ->setAuthor($author);
                $manager->persist($book);
            }
        }

        $manager->flush();
    }
}

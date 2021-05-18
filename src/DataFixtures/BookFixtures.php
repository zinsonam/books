<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        $cat = new Category();
        $cat->setName('Autre');

        for ($i=1; $i<=5 ; $i++){
            $book = new Book();

            $book->setCategory($cat);

            $book->setAuteur($faker->word());
            $book->setGenre($faker->word());
            $book->setTitre($faker->word());
            $book->setType($faker->word());
            $book->setPrix($faker->randomFloat(2, 2, 100));
            $book->setQuantite(mt_rand(1, 10));

            $manager->persist($book);

        }

        $manager->flush();
    }
}

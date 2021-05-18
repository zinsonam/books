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
        for ($j=1; $j<=5 ; $j++){
        $cat = new Category();
        $cat->setName($faker->company());
        
        for ($i=1; $i<=5 ; $i++){
            $book = new Book();

            $book->setCategory($cat);
            $auteur = $faker->firstNameFemale()." ".$faker->lastName();
            $book->setAuteur($auteur);
            $book->setGenre($faker->word());
            $book->setTitre($faker->sentence($nbWords = 6, $variableNbWords = true));
            $book->setType($faker->word());
            $book->setPrix($faker->randomFloat(2, 2, 100));
            $book->setQuantite(mt_rand(1, 10));

            $manager->persist($book);

        }
    }
        $manager->flush();
    }
}

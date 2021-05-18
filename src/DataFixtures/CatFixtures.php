<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CatFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');

        for ($i = 1; $i <= 5; $i++) {
        $category = new Category();
        $category->setName($faker->word());
        
        $manager->persist($category);
        }
        $manager->flush();
    }
}

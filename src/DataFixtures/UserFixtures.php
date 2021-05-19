<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');

        // creation des données utilisateur avec Faker
        // penser à l'installer avant
        // composer require fakerphp/faker
        // ***************************************************

        //Creation user admin
        $admin = new User();
        $admin->setNom("Martin")
        ->setPrenom("Luc")

        ->setPassword('$2y$13$hRrss14obgPmuQz3wudoOuDJzpSZ6Y/cMNWot48tK737KdUIDxCKu')
        ->setAdresse("255 rue des toutou, 77410 Roissy")
        ->setTelephone("06 33 22 11 55")
        ->setDateCreation(new \DateTime())
        ->setScore(10)
        ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
        ->setEmail("luc.martin@gmail.com");

        $manager->persist($admin);

        //Creation autre users utilisateur
        for($i=1;$i<=10; $i++){
            $user = new User();
            $user->setNom($faker->lastName())
            ->setPrenom($faker->firstName())

            ->setPassword('$2y$13$hRrss14obgPmuQz3wudoOuDJzpSZ6Y/cMNWot48tK737KdUIDxCKu')
            ->setAdresse($faker->address())
            ->setTelephone($faker->e164PhoneNumber())
            ->setDateCreation(new \DateTime())
            ->setRoles(['ROLE_USER'])
            ->setScore(10);
            // info dans $user ou faker
            $email =  strtolower($user->getNom()) . '.' . strtolower($user->getPrenom()) . "@" . $faker->freeEmailDomain();
            $user->setEmail($email);

            $manager->persist($user);

        }

        $manager->flush();
    }

}

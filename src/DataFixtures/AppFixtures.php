<?php

namespace App\DataFixtures;

use App\Entity\Service;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // instanciation of faker
        $faker = Faker\Factory::create('fr_FR');

        // services name array
        $servicesList = [
            "Emplacement de tente",
            "Lit",
            "Abri",
            "Réception de colis",
            "Douche",
            "Eau",
            "Petit-déjeuner",
            "Sandwich", 
            "Dîner",
            "Prise électrique"
        ];

        // create services 
        foreach ($servicesList as $currentService) {
            
            $service= new Service();
            $service->setName($currentService);
            $service->setDescription($faker->sentence(6));
            $service->setImage('tent.png'); 
            $service->setSlug('my-slug');
            $manager->persist($service);
        }

        // create 20 user
        for ($i = 0; $i < 20; $i++) {

            $user = new User();
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $password = $this->encoder->hashPassword($user, 'pass_1234');
            $user->setPassword($password);
            $user->setCity($faker->city());
            $user->setZipCode(mt_rand(11100, 97499));
            $user->setRoles(['ROLE_USER']);
            $user->setPhoneNumber(0102030405);
            $user->setStatus(mt_rand(1, 2));
            
            // add a service to each user
            $user->addService($service);

            $manager->persist($user);
        } 
        
        $manager->flush();
    }
}

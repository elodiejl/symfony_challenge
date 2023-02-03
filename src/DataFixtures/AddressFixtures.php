<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<10; $i++) {
            $object = (new Address())
                ->setNumberStreet($faker->buildingNumber)
                ->setNameStreet($faker->streetAddress)
                ->setLocalCode($faker->countryCode)
                ->setCity($faker->city)
                ->setCountry($faker->country)
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}

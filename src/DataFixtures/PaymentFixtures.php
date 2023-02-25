<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PaymentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++){
            $object = (new Payment())
                ->setCryptoNum($faker->numberBetween(100,999))
                ->setDateLimit($faker->creditCardExpirationDate)
                ->setNameCard($faker->name)
                ->setNumCard($faker->creditCardNumber())
            ;

            $manager->persist($object);
        }

        $manager->flush();
    }
}

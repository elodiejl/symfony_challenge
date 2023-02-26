<?php

namespace App\DataFixtures;

use App\Entity\Art;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $art = $manager->getRepository(Art::class)->findAll();
        $user = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 30; $i++){
            $date_order = new \DateTime($faker->date('Y-m-d', 'now'));
            $date_delivery = new \DateTime($faker->date('Y-m-d'));
            $object = (new Order())
                ->setArt($faker->randomElement($art))
                //->setDateDelivery(/*$date_delivery->format('Y-m-d')*/)
                ->setDateOrder(new \DateTime())
                ->setNumOrder($faker->numberBetween(100000, 999999))
                ->setTotalPrice($faker->numberBetween(100, 100000))
                ->setUser($faker->randomElement($user))
            ;

            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}

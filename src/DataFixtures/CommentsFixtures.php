<?php

namespace App\DataFixtures;

use App\Entity\Comments;
use App\Entity\Art;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $art = $manager->getRepository(Art::class)->findAll();

        for ($i = 0; $i < 30; $i++){
            $object = (new Comments())
                ->setMessage($faker->sentence)
                ->setArt($faker->randomElement($art))
            ;

            $manager->persist($object);
        }

        $manager->flush();

        //->setImageFile($faker->randomElement(/*$image[$random_category])*/)
    }

    public function getDependencies()
    {
        return [
            ArtFixtures::class,
        ];
    }
}

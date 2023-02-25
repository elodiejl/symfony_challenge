<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $object1 = (new Category())
            ->setLabel('Peinture')
            ->setColorLabel($faker->colorName)
        ;
        $manager->persist($object1);

        $object2 = (new Category())
            ->setLabel('Sculpture')
            ->setColorLabel($faker->colorName)
        ;
        $manager->persist($object2);

        $object3 = (new Category())
            ->setLabel('Dessin')
            ->setColorLabel($faker->colorName)
        ;
        $manager->persist($object3);

        $object4 = (new Category())
            ->setLabel('Gravure')
            ->setColorLabel($faker->colorName)
        ;
        $manager->persist($object4);

        $object5 = (new Category())
            ->setLabel('Photographie')
            ->setColorLabel($faker->colorName)
        ;
        $manager->persist($object5);

        $manager->flush();
    }
}

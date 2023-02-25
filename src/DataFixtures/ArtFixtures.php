<?php

namespace App\DataFixtures;

use App\Entity\Art;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArtFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $category = $manager->getRepository(Category::class)->findAll();

        $image = ['tableau1', 'tableau2', 'tableau3','sculpture1', 'sculpture2','newArt'];

        for ($i = 0; $i < 30; $i++){
            $object = (new Art())
                ->setLabel($faker->word)
                ->setArtist($faker->name)
                ->setCategory($faker->randomElement($category))
                ->setDescription($faker->sentence)
                ->setImageFile($faker->randomElement($image))
                ->setHeight($faker->numberBetween(50, 1000))
                ->setImage($faker->title)
                ->setPrice($faker->randomFloat())
                ->setSold($faker->boolean())
                ->setWidth($faker->numberBetween(50, 1000))
                ;

            $manager->persist($object);
        }

        $manager->flush();

        //->setImageFile($faker->randomElement(/*$image[$random_category])*/)
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

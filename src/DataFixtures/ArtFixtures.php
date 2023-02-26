<?php

namespace App\DataFixtures;

use App\Entity\Art;
use App\Entity\Category;
use App\Entity\User;
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
        $users = $manager->getRepository(User::class)->findAll();

        $image = ['image-1-63f95f66a5fc5.jpg', 'tableau1.png', 'tableau2.png', 'tableau3.png','sculpture1.png', 'sculpture2.png','newArt.png'];

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
                ->setVendor($faker->randomElement($users)->getId())
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

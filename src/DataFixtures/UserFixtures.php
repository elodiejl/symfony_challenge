<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // pwd: test
        $pwd = '$2y$13$wiWVplNfdpwyWjWFdTtY..TQvVVHDVkv/PEUtf7dSlvmC2KiqlJHq';

        $address = $manager->getRepository(Address::class)->findAll();

        $object = (new User())
            ->setFirstname('Rounard')
            ->setLastname('Volpolo')
            ->setEmail('rounorama-rounard@outlook.fr')
            ->setPassword($pwd)
            ->setBirthday(new \DateTime('2001-10-18'))
            ->setPseudo('Rounard')
            ->setRoles(["ROLE_ADMIN"])
            ->setIsVerified(true)
            ->setAddress($faker->randomElement($address))
        ;
        $manager->persist($object);

        for ($i=0; $i<2; $i++) {
            $object = (new User())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword(password_hash($faker->password(), PASSWORD_BCRYPT))
                ->setBirthday(new \DateTime($faker->date('Y-m-d', '2005-01-01')))
                ->setPseudo($faker->userName)
                ->setIsVerified(false)
                ->setAddress($faker->randomElement($address))
            ;
            $manager->persist($object);
        }


        for ($i=0; $i<2; $i++) {
            $pwd = $faker->password();
            $object = (new User())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword(password_hash($pwd, PASSWORD_BCRYPT ))
                ->setBirthday(new \DateTime($faker->date('Y-m-d', '2005-01-01')))
                ->setPseudo($faker->userName)
                ->setRoles(["ROLE_VENDOR"])
                ->setIsVerified(true)
                ->setAddress($faker->randomElement($address))
            ;
            $manager->persist($object);
        }

        for ($i=0; $i<2; $i++) {
            $object = (new User())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword(password_hash($faker->password(),PASSWORD_BCRYPT))
                ->setBirthday(new \DateTime($faker->date('Y-m-d', '2005-01-01')))
                ->setPseudo($faker->userName)
                ->setRoles(["ROLE_BUYER"])
                ->setIsVerified(true)
                ->setAddress($faker->randomElement($address))
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}

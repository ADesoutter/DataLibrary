<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory as FakerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager; 
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture implements DependentFixturesInterface
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = \Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {

            $user = new User();
            $user->setEmail('admin@example.com');
            $user->setRoles(['ROLE_ADMIN']);
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);

            $user = new User();
            $user->setEmail('foo.foo@example.com');
            $user->setRoles(['ROLE_EMPRUNTEUR']);
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);

            $user = new User();
            $user->setEmail('bar.bar@example.com');
            $user->setRoles(['ROLE_EMPRUNTEUR']);
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);

            $user = new User();
            $user->setEmail('baz.baz@example.com');
            $user->setRoles(['ROLE_EMPRUNTEUR']);
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);

            for($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setRoles(['ROLE_EMPRUNTEUR']);
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            }
            

            $manager->persist($user);

            // enregistre l'utilisateur dans une référence
            $this->addReference('user_', $user);

            $manager->flush();
    }
}

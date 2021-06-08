<?php

namespace App\DataFixtures;

use App\Entity\Borrower;
use Faker\Factory as FakerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BorrowerFixtures extends Fixture implements DependentFixturesInterface
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = \Faker\Factory::create('en_US');
    }

    public function load(ObjectManager $manager)
    {

        
        $borrowers = [];

        $borrower = new Borrower();
        $borrower->setLastname($this->faker->lastname());
        $borrower->setFirstname($this->faker->firstname());
        $borrower->setPhone($this->faker->phoneNumber());
        $borrower->setActif(true);
        $borrower->setCreationDate($this->faker->);
        $borrower->setModificationDate($this->faker->);
        $manager->persist($borrower);



        $borrower = new Borrower();
        $borrower->setLastname($this->faker->lastname());
        $borrower->setFirstname($this->faker->firstname());
        $borrower->setPhone($this->faker->phoneNumber());
        $borrower->setActif(true);
        $borrower->setCreationDate($this->faker->);
        $borrower->setModificationDate($this->faker->);
        $manager->persist($borrower);

        $manager->flush();
    }
}

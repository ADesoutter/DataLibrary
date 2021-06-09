<?php

namespace App\DataFixtures;

use App\Entity\Borrower;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
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
        $this->faker = \Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {

        $borrowers = [];

        $borrower = new Borrower();
        $borrower->setLastname('foo');
        $borrower->setFirstname('foo');
        $borrower->setPhone('123456789');
        $borrower->setActif(true);
        $borrower->setCreationDate('2020-01-01 10:00:00');
        $borrower->setModificationDate(NULL);
        $manager->persist($borrower);
        $borrowers[] = $borrower;

        $borrower = new Borrower();
        $borrower->setLastname('bar');
        $borrower->setFirstname('bar');
        $borrower->setPhone('123456789');
        $borrower->setActif(false);
        $borrower->setCreationDate('2020-02-01 11:00:00');
        $borrower->setModificationDate('2020-05-01 12:00:00');
        $manager->persist($borrower);
        $borrowers[] = $borrower;

        $borrower = new Borrower();
        $borrower->setLastname('foo');
        $borrower->setFirstname('foo');
        $borrower->setPhone('123456789');
        $borrower->setActif(true);
        $borrower->setCreationDate('2020-03-01 12:00:00');
        $borrower->setModificationDate(NULL);
        $manager->persist($borrower);
        $borrowers[] = $borrower;


        for($i = 1; $i <= 100; $i++) {
            $borrower = new Borrower();
            $borrower->setLastname($this->faker->lastname());
            $borrower->setFirstname($this->faker->firstname());
            $borrower->setPhone($this->faker->phoneNumber());
            $borrower->setActif($this->faker->boolean);
            // utilisation de DateTimeThisYear
            $borrower->setCreationDate($this->faker->dateTimeThisYear());
            $creationDate = \DateTime::createFromFormat('Y-m-d H:i:s');
            $borrower->setModificationDate($this->faker->dateTimeThisYear());
            $modificationDate = \DateTime::createFromFormat('Y-m-d H:i:s');

            $manager->persist($borrower);
            $borrowers[] = $borrower;
        }
        $this->addReference('borrower_', $borrower);

        $manager->flush();
    }

    public function getDependencies()
        {
        return [
            UserFixtures::class,
            BorrowingFixtures::class,
        ];
    }
}

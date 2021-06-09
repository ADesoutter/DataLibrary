<?php

namespace App\DataFixtures;

use App\Entity\Borrowing;
use Faker\Factory as FakerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BorrowingFixtures extends Fixture
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

        $borrowings = [];

        $borrowing = new Borrowing();
        $borrowing->setBorrowingDate('2020-02-01 10:00:00');
        $borrowing->setModificationDate(NULL);
        $manager->persist($borrower);

        $borrowings[] = $borrowing;


        $borrowing = new Borrowing();
        $borrowing->setBorrowingDate('2020-03-01 10:00:00');
        $borrowing->setReturnDate(NULL);
        $manager->persist($borrower);

        $borrowings[] = $borrowing;


        $borrowing = new Borrowing();
        $borrowing->setBorrowingDate('2020-04-01 10:00:00');
        $borrowing->setReturnDate(NULL);
        $manager->persist($borrower);

        $borrowings[] = $borrowing;


        for($i = 1; $i <= 200; $i++) {
            $borrowing = new Borrowing();
            $borrowing->setBorrowingDate($this->faker->dateTimeThisDecade());
            // création de la date de début
            $borrowingDate = \DateTime::createFromFormat('Y-m-d H:i:s');
            // ajout d'un interval de 3 semaines à la date de début
            $returnDate->add(new \DateInterval('P3W'));
            $borrowing->setReturnDate($returnDate);
            $manager->persist($borrowing);
        }
            $borrowings[] = $borrowing;

        $manager->persist($borrowing);

        $this->addReference('borrowing_', $borrowing);

        $manager->flush();
    }
}

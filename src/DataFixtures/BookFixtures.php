<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use Faker\Factory as FakerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BookFixtures extends Fixture
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

        $books = [];

        $book = new Book();
        $book->setTitle('Lorem ipsum dolor sit amet');
        $book->setYearEdition('2010');
        $book->setNumberPages('100');
        $book->setCodeIsbn('9785786930024');
        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Consectetur adipiscing elit');
        $book->setYearEdition('2011');
        $book->setNumberPages('150');
        $book->setCodeIsbn('9783817260935');
        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Mihi quidem Antiochum');
        $book->setYearEdition('2012');
        $book->setNumberPages('200');
        $book->setCodeIsbn('9782020493727');
        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Quem audis satis belle');
        $book->setYearEdition('2013');
        $book->setNumberPages('250');
        $book->setCodeIsbn('979459561353');
        $manager->persist($book);
        $books[] = $book;

    // Création de livres avec faker et la boucle= \DateTime::createFromFormat('Y-m-d H:i:s');
        for($i = 1; $i <= 1000; $i++) {
            $book->setTitle($this->faker->realTextBetween(6-12));
            $book->setYearEdition($this->faker->numberBetween(2000-2020));
            $book->setNumberPages($this->faker->numberBetween(100-300));
            $book->setCodeIsbn($this->faker->isbn13());
            $manager->persist($book);
            $books[] = $book;
        }

    // public static function books(): array
    // {
    //     return ['books'];
    // }
        
        // enregistre l'utilisateur dans une référence
        $this->addReference('book_', $book);

        $manager->flush();
    }

    // public function getDependencies()
    // {
    //     return [
    //         AuthorFixtures::class,
    //     ];
    // }

}

<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Faker\Factory as FakerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthorFixtures extends Fixture implements DependentFixturesInterface
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
        $authors = [];

        $author = new Author();
        $author->setLastname('unknown author');
        $author->setFirstname(' ');
        $manager->persist($author);

        $author[] = $author;

        $author = new Author();
        $author->setLastname('Cartier');
        $author->setFirstname('Hugues');
        $manager->persist($author);

        $author[] = $author;

        $author = new Author();
        $author->setLastname('Lambert');
        $author->setFirstname('Armand');
        $manager->persist($author);
        $manager->persist($book);
        $author[] = $author;

        $author = new Author();
        $author->setLastname('Moitessier');
        $author->setFirstname('Thomas');
        $manager->persist($author);

        $author[] = $author;

    // Création d'auteurs avec faker et la boucle
        for($i = 0; $i < 500; $i++) {
            $author = new Author();
            $author->setLastname($this->faker->lastname());
            $author->setFirstname($this->faker->firstname());
            $manager->persist($author);
        }
        
        $manager->flush();
    }

   /*
    public function getDependencies()
    {
        return [
            userFixtures::class
        ];
    }
    */
}


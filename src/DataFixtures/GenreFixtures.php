<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $genres = [];

        $genre = new Genre();
        $book->setName("poésie");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("nouvelle");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("roman historique");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("roman d'amour");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("roman d'aventure");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("science-fiction");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("fantasy");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("biographie");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("conte");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("témoignage");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("théâtre");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("essai");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $genre = new Genre();
        $book->setName("journal intime");
        $book->setDescription("NULL");
        $genres[] = $genre;

        $manager->persist($genre);

        $manager->flush();
    }
}

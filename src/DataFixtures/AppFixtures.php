<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Borrower;
use App\Entity\Borrowing;
use App\Entity\Genre;
use App\Entity\User;
use Faker\Factory as FakerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = \Faker\Factory::create('fr_FR');
    }

    public static function getGroups(): array
    {
        // Cette fixture fait partie du groupe "test".
        // Cela permet de cibler seulement certains fixtures
        // quand on exécute la commande doctrine:fixtures:load.
        // Pour que la méthode statique getGroups() soit prise
        // en compte, il faut que la classe implémente
        // l'interface FixtureGroupInterface.
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        
        // Appel des fonctions qui vont créer les objets dans la BDD.
        // La fonction loadAdmins() ne renvoit pas de données mais les autres
        // fontions renvoit des données qui sont nécessaires à d'autres fonctions.
        $this->loadAdmins($manager);
        $users = $this->loadAdmins($manager);
        $authors = $this->loadAuthors($manager, 500);
        $books = $this->loadBooks($manager, $authors, $genres);
        $genres = $this->loadGenres($manager, $books);
        $borrowings = $this->loadBorrowings($manager, $borrowers, $books);
        $borrowers = $this->loadBorrowers($manager, 100);

        // Exécution des requêtes.
        // C-à-d envoi de la requête SQL à la BDD.
        $manager->flush();
    }

    public function loadAdmins(ObjectManager $manager)
    {

        // Création d'un tableau d'utilisateurs
        $users = [];

        // nouvel utilisateur avec un role ADMIN
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);
        $users[] = $user;

        // QUE FAIRE AVEC LES AUTRES UTILISATEURS
        // Création de nouveaux utilisateurs avec un role EMPRUNTEUR
        $user = new User();
        $user->setEmail('foo.foo@example.com');
        $user->setRoles(['ROLE_EMPRUNTEUR']);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);
        $users[] = $user;

        $user = new User();
        $user->setEmail('bar.bar@example.com');
        $user->setRoles(['ROLE_EMPRUNTEUR']);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);
        $users[] = $user;

        $user = new User();
        $user->setEmail('baz.baz@example.com');
        $user->setRoles(['ROLE_EMPRUNTEUR']);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);
        $users[] = $user;

        for($i = 1; $i <= 100; $i++) {
        $user = new User();
        $user->setEmail($this->faker->email());
        $user->setRoles(['ROLE_EMPRUNTEUR']);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);
        $users[] = $user;
        }

        return $users;
    }

    public function loadAuthors(ObjectManager $manager)
    {
        $authors = [];

        $author = new Author();
        $author->setLastname('unknown author');
        $author->setFirstname(' ');
        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Cartier');
        $author->setFirstname('Hugues');
        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Lambert');
        $author->setFirstname('Armand');
        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Moitessier');
        $author->setFirstname('Thomas');
        $manager->persist($author);
        $authors[] = $author;

    // Création d'auteurs avec faker et la boucle
        for($i = 1; $i <= 500; $i++) {
            $author = new Author();
            $author->setLastname($this->faker->lastname());
            $author->setFirstname($this->faker->firstname());
            $manager->persist($author);
            $authors[] = $author;
        }

        return $authors;
    }


    public function loadBooks(ObjectManager $manager, array $authors)
    {

        $authors = $this->getReference('authors');
        $books = [];

        $book = new Book();
        $book->setTitle('Lorem ipsum dolor sit amet');
        $book->setYearEdition('2010');
        $book->setNumberPages('100');
        $book->setCodeIsbn('9785786930024');
        $book->setAuthor($authors[0]);
        $book->addKind($kinds[0]);

        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Consectetur adipiscing elit');
        $book->setYearEdition('2011');
        $book->setNumberPages('150');
        $book->setCodeIsbn('9783817260935');
        $book->setAuthor($authors[1]);
        $book->addKind($kinds[1]);

        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Mihi quidem Antiochum');
        $book->setYearEdition('2012');
        $book->setNumberPages('200');
        $book->setCodeIsbn('9782020493727');
        $book->setAuthor($authors[2]);
        $book->addKind($kinds[2]);

        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Quem audis satis belle');
        $book->setYearEdition('2013');
        $book->setNumberPages('250');
        $book->setCodeIsbn('979459561353');
        $book->setAuthor($authors[3]);
        $book->addKind($kinds[3]);

        $manager->persist($book);
        $books[] = $book;

    // Création de livres avec faker et la boucle= \DateTime::createFromFormat('Y-m-d H:i:s');
        for($i = 0; $i < 1000; $i++) {

            // Choisir un auteur et un genre random 
            $randomAuthor = $this->faker->randomElement($authors);
            $randomGenre = $this->faker->randomElement($genres);
            $book->setTitle($this->faker->realTextBetween($min = 6, $max = 12));
            $book->setYearEdition($this->faker->numberBetween($min = 2000, $max = 2020));
            $book->setNumberPages($this->faker->numberBetween($min = 100, $max = 300));
            $book->setCodeIsbn($this->faker->isbn13());

            // relations : Many to One avec author : set
            $book->setAuthor($randomAuthor);
            // relations : Many to Many avec genre : add
            $book->addGenre($randomGenre);

            $manager->persist($book);
            $books[] = $book;
        }

        return $books;
    }

    
    public function loadGenres(ObjectManager $manager)
    {

        $genres = [];

        $genre = new Genre();
        $genre->setName("poésie");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("nouvelle");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("roman historique");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("roman d'amour");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("roman d'aventure");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("science-fiction");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("fantasy");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("biographie");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("conte");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("témoignage");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("théâtre");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("essai");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        $genre = new Genre();
        $genre->setName("journal intime");
        $genre->setDescription("NULL");
        $manager->persist($genre);
        $genres[] = $genre;

        return $genres;
      
    }

    public function loadBorrowings(ObjectManager $manager)
    {

        $borrowings = [];

        // 1er Emprunt
        $borrowing = new Borrowing();
        $borrowing->setBorrowingDate (\DateTime::createFromFormat('Y-m-d H:i:s','2020-02-01 10:00:00'));
        $borrowingDate = $borrowing->getBorrowingDate();
        $modificationDate = \DateTime::createFromFormat('Y-m-d H:i:s',  $borrowingDate->format('Y-m-d H:i:s'));
        // ajout d'un interval d' 1 mois à la date de début   
        $modificationDate->add(new \DateInterval('P1M'));
        $borrowing->setReturnDate($modificationDate);
        $borrowing->setBorrower($borrowers[0]);
        $borrowing->setBook($books[0]);

        $manager->persist($borrowing);
        $borrowings[] = $borrowing;

        // 2ème emprunt
        $borrowing = new Borrowing();
        $borrowing->setBorrowingDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-03-01 10:00:00'));
        $borrowingDate = $borrowing->getBorrowingDate();
        $modificationDate = \DateTime::createFromFormat('Y-m-d H:i:s',  $borrowingDate->format('Y-m-d H:i:s'));
        // ajout d'un interval d' 1 mois à la date de début
        $modificationDate->add(new \DateInterval('P1M'));
        $borrowing->setReturnDate($modificationDate);
        $borrowing->setBorrower($borrowers[1]);
        $borrowing->setBook($books[1]);

        $manager->persist($borrower);
        $borrowings[] = $borrowing;

        // 3ème emprunt
        $borrowing = new Borrowing();
        $borrowing->setBorrowingDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-04-01 10:00:00'));
        $borrowingDate = $borrowing->getBorrowingDate();
        $modificationDate = \DateTime::createFromFormat('Y-m-d H:i:s',  $borrowingDate->format('Y-m-d H:i:s'));
        $borrowing->setReturnDate(NULL);
        $borrowing->setBorrower($borrowers[2]);
        $borrowing->setBook($books[2]);

        $manager->persist($borrower);
        $borrowings[] = $borrowing;


        for($i = 0; $i < 200; $i++) {

            // Utilisation du random pour créer des données aléatoires
            $randomBorrower = $this->faker->randomElement($borrowers);
            $randomBook = $this->faker->randomElement($books);

            $borrowing = new Borrowing();
            $borrowing->setBorrowingDate($this->faker->dateTime());
            $borrowingDate = $borrowing->getBorrowingDate();
            // création de la date de début
            $modificationDate = \DateTime::createFromFormat('Y-m-d H:i:s',  $borrowingDate->format('Y-m-d H:i:s'));

            // Relation Many to One avec Borrower
            $borrowing->setBorrower($randomBorrower);
            // Relation Many to One avec Book
            $borrowing->setBook($randomBook);

            $manager->persist($borrowing);
            $borrowings[] = $borrowing;
        }
            
        return $borrowings;
 
    }

    public function loadBorrowers(ObjectManager $manager)
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

        return $borrowers;
    }
    
}

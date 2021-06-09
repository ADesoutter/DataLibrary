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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
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
        // Définition du nombre d'objets qu'il faut créer.
        $schoolYearCount = 10;
        $studentsPerSchoolYear = 24;
        // Le nombre de students à créer dépend du nombre  de
        // school years et du nombre de students par school year.
        $studentsCount = $studentsPerSchoolYear * $schoolYearCount;
        $studentsPerProject = 3;

        // Le nombre de projects à créer dépend du nombre  de
        // students et du nombre de students par project.
        if ($studentsCount % $studentsPerProject == 0) {
            // Il y a suffisamment de projects pour chaque student.
            // C-à-d que le reste de la division euclidienne (le
            // modulo) est nulle.
            // La division renvoit un float, c'est pourquoi il est nécessaire
            // de type caster la valeur de la division en (int).
            $projectsCount = (int) ($studentsCount / $studentsPerProject);
        } else {
            // Il n'y a pas suffisamment de projects pour chaque student.
            // C-à-d que le reste de la division euclidienne (le
            // modulo) n'est pas nulle.
            // On rajoute un project supplémentaire.
            // La division renvoit un float, c'est pourquoi il est nécessaire
            // de type caster la valeur de la division en (int).
            $projectsCount = (int) ($studentsCount / $studentsPerProject) + 1;
        }

        // Appel des fonctions qui vont créer les objets dans la BDD.
        // La fonction loadAdmins() ne renvoit pas de données mais les autres
        // fontions renvoit des données qui sont nécessaires à d'autres fonctions.
        $this->loadAdmins($manager, 3);
        $users = $this->loadAdmins($manager, $schoolYears);
        // La fonction loadStudents() a besoin de la liste des school years.
        $authors = $this->loadAuthors($manager, $schoolYears);
        $books = $this->loadBooks($manager, $schoolYears);
        $genres = $this->loadGenres($manager, $borrowings, 20);
        // La fonction loadProjects() a besoin de la liste des students.
        $borrowings = $this->loadBorrowings($manager, $students, $studentsPerProject);
        // La fonction loadTeachers() a besoin de la liste des projects.
        $borrowers = $this->loadBorrowers($manager, $borrowings, 20);

        // @todo créer les clients et les tags

        // Exécution des requêtes.
        // C-à-d envoi de la requête SQL à la BDD.
        $manager->flush();
    }

    public function loadAdmins(ObjectManager $manager, int $count)
    {

        $users = [];
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);
        $users[] = $user;

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

    public function loadBooks(ObjectManager $manager)
    {

        $authors = $this->getReference('authors');
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
            $book->setTitle($this->faker->realTextBetween(6,12));
            $book->setYearEdition($this->faker->numberBetween(2000,2020));
            $book->setNumberPages($this->faker->numberBetween(100,300));
            $book->setCodeIsbn($this->faker->isbn13());
            $manager->persist($book);
            $books[] = $book;
        }

        return $books;
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

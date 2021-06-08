<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=190)
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year_edition;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_pages;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $code_isbn;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Borrowing::class, mappedBy="book")
     */
    private $borrowings;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, mappedBy="books")
     */
    private $genres;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->borrowings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getYearEdition(): ?int
    {
        return $this->year_edition;
    }

    public function setYearEdition(?int $year_edition): self
    {
        $this->year_edition = $year_edition;

        return $this;
    }

    public function getNumberPages(): ?int
    {
        return $this->number_pages;
    }

    public function setNumberPages(int $number_pages): self
    {
        $this->number_pages = $number_pages;

        return $this;
    }

    public function getCodeIsbn(): ?string
    {
        return $this->code_isbn;
    }

    public function setCodeIsbn(?string $code_isbn): self
    {
        $this->code_isbn = $code_isbn;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection|Borrowing[]
     */
    public function getBorrowings(): Collection
    {
        return $this->borrowings;
    }

    public function addBorrowing(Borrowing $borrowing): self
    {
        if (!$this->borrowings->contains($borrowing)) {
            $this->borrowings[] = $borrowing;
            $borrowing->setBook($this);
        }

        return $this;
    }

    public function removeBorrowing(Borrowing $borrowing): self
    {
        if ($this->borrowings->removeElement($borrowing)) {
            // set the owning side to null (unless already changed)
            if ($borrowing->getBook() === $this) {
                $borrowing->setBook(null);
            }
        }

        return $this;
    }
}

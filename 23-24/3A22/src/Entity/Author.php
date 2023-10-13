<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class)]
    private Collection $book_author;

    public function __construct()
    {
        $this->book_author = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBookAuthor(): Collection
    {
        return $this->book_author;
    }

    public function addBookAuthor(Book $bookAuthor): static
    {
        if (!$this->book_author->contains($bookAuthor)) {
            $this->book_author->add($bookAuthor);
            $bookAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeBookAuthor(Book $bookAuthor): static
    {
        if ($this->book_author->removeElement($bookAuthor)) {
            // set the owning side to null (unless already changed)
            if ($bookAuthor->getAuthor() === $this) {
                $bookAuthor->setAuthor(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;



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
     * @ORM\Column(type="string", length=255)
     * @Groups({"book_get"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"book_get"}) 
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"book_get"})
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"book_get"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"book_get"})
     */
    private $quantite;

    /**
     * @ORM\Column(type="float")
     * @Groups({"book_get"})
     */
    private $prix;

    //ajouter cascade={"persist"} pour le problem de liaison enter categorie et book
    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books", cascade={"persist"})
     * @Groups({"book_get"})
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}

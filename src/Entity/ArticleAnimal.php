<?php

namespace App\Entity;

use App\Repository\ArticleAnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleAnimalRepository::class)]
class ArticleAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Animal_name = null;

    #[ORM\Column]
    private ?int $Status = null;

    #[ORM\Column]
    private ?int $Age = null;

    #[ORM\Column(length: 500)]
    private ?string $Content = null;

    // Relation many to One de la Table articleAnimals à Type (articleAnimals peut recevoir plusieurs informations de la Table Type)
    #[ORM\ManyToOne(inversedBy: 'articleAnimals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $Type = null;

    #[ORM\ManyToOne(inversedBy: 'articleAnimals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OriginCountry $Origin_country = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'articleAnimal')]
    private Collection $Comment;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    private ?string $Species = null;

    public function __construct()
    {
        $this->Comment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimalName(): ?string
    {
        return $this->Animal_name;
    }

    public function setAnimalName(string $Animal_name): static
    {
        $this->Animal_name = $Animal_name;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->Status;
    }

    public function setStatus(int $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): static
    {
        $this->Age = $Age;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->Type;
    }

    public function setType(?Type $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getOriginCountry(): ?OriginCountry
    {
        return $this->Origin_country;
    }

    public function setOriginCountry(?OriginCountry $Origin_country): static
    {
        $this->Origin_country = $Origin_country;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->Comment->contains($comment)) {
            $this->Comment->add($comment);
            $comment->setArticleAnimal($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->Comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticleAnimal() === $this) {
                $comment->setArticleAnimal(null);
            }
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->Species;
    }

    public function setSpecies(string $Species): static
    {
        $this->Species = $Species;

        return $this;
    }
}

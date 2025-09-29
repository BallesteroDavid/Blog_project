<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, ArticleAnimal>
     */
    #[ORM\OneToMany(targetEntity: ArticleAnimal::class, mappedBy: 'Type')]
    private Collection $articleAnimals;

    public function __construct()
    {
        $this->articleAnimals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ArticleAnimal>
     */
    public function getArticleAnimals(): Collection
    {
        return $this->articleAnimals;
    }

    public function addArticleAnimal(ArticleAnimal $articleAnimal): static
    {
        if (!$this->articleAnimals->contains($articleAnimal)) {
            $this->articleAnimals->add($articleAnimal);
            $articleAnimal->setType($this);
        }

        return $this;
    }

    public function removeArticleAnimal(ArticleAnimal $articleAnimal): static
    {
        if ($this->articleAnimals->removeElement($articleAnimal)) {
            // set the owning side to null (unless already changed)
            if ($articleAnimal->getType() === $this) {
                $articleAnimal->setType(null);
            }
        }

        return $this;
    }
}

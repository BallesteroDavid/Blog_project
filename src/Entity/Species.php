<?php

namespace App\Entity;

use App\Repository\SpeciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, ArticleAnimal>
     */
    #[ORM\OneToMany(targetEntity: ArticleAnimal::class, mappedBy: 'Species')]
    private Collection $articleAnimals;

    public function __construct()
    {
        $this->articleAnimals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $articleAnimal->setSpecies($this);
        }

        return $this;
    }

    public function removeArticleAnimal(ArticleAnimal $articleAnimal): static
    {
        if ($this->articleAnimals->removeElement($articleAnimal)) {
            // set the owning side to null (unless already changed)
            if ($articleAnimal->getSpecies() === $this) {
                $articleAnimal->setSpecies(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\OriginCountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OriginCountryRepository::class)]
class OriginCountry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Country = null;

    /**
     * @var Collection<int, ArticleAnimal>
     */
    #[ORM\OneToMany(targetEntity: ArticleAnimal::class, mappedBy: 'Origin_country')]
    private Collection $articleAnimals;

    public function __construct()
    {
        $this->articleAnimals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): static
    {
        $this->Country = $Country;

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
            $articleAnimal->setOriginCountry($this);
        }

        return $this;
    }

    public function removeArticleAnimal(ArticleAnimal $articleAnimal): static
    {
        if ($this->articleAnimals->removeElement($articleAnimal)) {
            // set the owning side to null (unless already changed)
            if ($articleAnimal->getOriginCountry() === $this) {
                $articleAnimal->setOriginCountry(null);
            }
        }

        return $this;
    }
}

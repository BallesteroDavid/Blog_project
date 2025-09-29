<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Commentary = null;

    #[ORM\ManyToOne(inversedBy: 'Comment')]
    private ?ArticleAnimal $articleAnimal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentary(): ?string
    {
        return $this->Commentary;
    }

    public function setCommentary(string $Commentary): static
    {
        $this->Commentary = $Commentary;

        return $this;
    }

    public function getArticleAnimal(): ?ArticleAnimal
    {
        return $this->articleAnimal;
    }

    public function setArticleAnimal(?ArticleAnimal $articleAnimal): static
    {
        $this->articleAnimal = $articleAnimal;

        return $this;
    }
}

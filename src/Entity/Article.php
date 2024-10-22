<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $article_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $article_description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $article_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $article_datemodif = null;

    public function getArticleId(): ?int
    {
        return $this->article_id;
    }

    public function getArticleDescription(): ?string
    {
        return $this->article_description;
    }

    public function setArticleDescription(?string $article_description): static
    {
        $this->article_description = $article_description;

        return $this;
    }

    public function getArticleDate(): ?\DateTimeInterface
    {
        return $this->article_date;
    }

    public function setArticleDate(\DateTimeInterface $article_date): static
    {
        $this->article_date = $article_date;

        return $this;
    }

    public function getArticleDatemodif(): ?\DateTimeInterface
    {
        return $this->article_datemodif;
    }

    public function setArticleDatemodif(?\DateTimeInterface $article_datemodif): static
    {
        $this->article_datemodif = $article_datemodif;

        return $this;
    }
}

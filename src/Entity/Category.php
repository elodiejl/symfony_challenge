<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color_label = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Art::class)]
    private Collection $art;

    public function __construct()
    {
        $this->art = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getColorLabel(): ?string
    {
        return $this->color_label;
    }

    public function setColorLabel(?string $color_label): self
    {
        $this->color_label = $color_label;

        return $this;
    }

    /**
     * @return Collection<int, Art>
     */
    public function getArt(): Collection
    {
        return $this->art;
    }

    public function addArtId(Art $art): self
    {
        if (!$this->art->contains($art)) {
            $this->art->add($art);
            $art->setCategoryId($this);
        }

        return $this;
    }
}

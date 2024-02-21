<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $area = null;

    #[ORM\Column(length: 2082, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(targetEntity: Instruction::class, mappedBy: 'meal')]
    private Collection $instruction;

    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'meal')]
    private Collection $Ingredient;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'meal')]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: Favorites::class, mappedBy: 'meal')]
    private Collection $favorites;

    public function __construct()
    {
        $this->instruction = new ArrayCollection();
        $this->Ingredient = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): static
    {
        $this->area = $area;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Instruction>
     */
    public function getInstruction(): Collection
    {
        return $this->instruction;
    }

    public function addInstruction(Instruction $instruction): static
    {
        if (!$this->instruction->contains($instruction)) {
            $this->instruction->add($instruction);
            $instruction->setMeal($this);
        }

        return $this;
    }

    public function removeInstruction(Instruction $instruction): static
    {
        if ($this->instruction->removeElement($instruction)) {
            // set the owning side to null (unless already changed)
            if ($instruction->getMeal() === $this) {
                $instruction->setMeal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredient(): Collection
    {
        return $this->Ingredient;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->Ingredient->contains($ingredient)) {
            $this->Ingredient->add($ingredient);
            $ingredient->setMeal($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->Ingredient->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getMeal() === $this) {
                $ingredient->setMeal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMeal($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMeal() === $this) {
                $comment->setMeal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favorites>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorites $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setMeal($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getMeal() === $this) {
                $favorite->setMeal(null);
            }
        }

        return $this;
    }
}

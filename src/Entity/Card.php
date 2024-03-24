<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $collector_number = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 350)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $cost = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $attack = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $defense = null;

    #[ORM\Column(length: 2000)]
    private ?string $image = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $effect_image = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $type_or_rarity = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardGame $CardGame = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollectorNumber(): ?int
    {
        return $this->collector_number;
    }

    public function setCollectorNumber(int $collector_number): static
    {
        $this->collector_number = $collector_number;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): static
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): static
    {
        $this->defense = $defense;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getEffectImage(): ?string
    {
        return $this->effect_image;
    }

    public function setEffectImage(?string $effect_image): static
    {
        $this->effect_image = $effect_image;

        return $this;
    }

    public function getTypeOrRarity(): ?int
    {
        return $this->type_or_rarity;
    }

    public function setTypeOrRarity(?int $type_or_rarity): static
    {
        $this->type_or_rarity = $type_or_rarity;

        return $this;
    }

    public function getCardGame(): ?CardGame
    {
        return $this->CardGame;
    }

    public function setCardGame(?CardGame $CardGame): static
    {
        $this->CardGame = $CardGame;

        return $this;
    }
}

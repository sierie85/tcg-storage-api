<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CardDTO
{
  public function __construct(
    public readonly int $id,
    #[Assert\NotBlank]
    public readonly int $collector_number,
    #[Assert\NotBlank]
    public readonly string $name,
    #[Assert\NotBlank]
    public readonly string $description,
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $cost,
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $attack,
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $defense,
    #[Assert\NotBlank]
    public readonly string $image,
    public readonly string $effect_image,
    public readonly int $type_or_rarity,
  ) {
  }
}

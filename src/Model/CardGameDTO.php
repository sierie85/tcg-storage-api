<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class CardGameDTO
{
  public function __construct(
    #[Assert\NotBlank]
    public readonly string $id,
    #[Assert\NotBlank]
    #[Groups('create')]
    public readonly string $name,
    #[Groups('create')]
    public readonly string $back_cover_image,
  ) {
  }
}

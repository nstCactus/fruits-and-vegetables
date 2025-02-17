<?php

namespace App\Entity;

use App\Entity\Enum\EdibleTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class AbstractEdible implements EdibleInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    protected string $name = '';

    #[ORM\Column(enumType: EdibleTypeEnum::class)]
    #[Assert\NotBlank]
    protected ?EdibleTypeEnum $type = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    protected int $quantity = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?EdibleTypeEnum
    {
        return $this->type;
    }

    public function setType(EdibleTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}

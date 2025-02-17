<?php

namespace App\Entity;

use App\Entity\Enum\EdibleTypeEnum;

interface EdibleInterface
{
    public function getId(): ?int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): static;

    public function getType(): ?EdibleTypeEnum;

    public function setType(EdibleTypeEnum $type): static;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): static;
}

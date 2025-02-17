<?php

namespace App\Factory;

use App\DTO\EdibleDTO;
use App\Entity\EdibleInterface;
use App\Entity\Enum\EdibleTypeEnum;
use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Service\UnitConverter;

class EdibleFactory
{
    public function __construct(private readonly UnitConverter $unitConverter)
    {}

    public function create(EdibleDTO $dto): EdibleInterface
    {
        $edible = match (EdibleTypeEnum::fromString($dto->type)) {
            EdibleTypeEnum::VEGETABLE => new Vegetable(),
            EdibleTypeEnum::FRUIT => new Fruit(),
        };

        $edible->setId($dto->id);
        $edible->setName($dto->name);
        $edible->setType(EdibleTypeEnum::fromString($dto->type));
        $edible->setQuantity($this->unitConverter->convertToGrams($dto->quantity, $dto->unit));

        return $edible;
    }
}

<?php

namespace App\Entity\Enum;

enum EdibleTypeEnum: string
{
    case FRUIT = 'fruit';
    case VEGETABLE = 'vegetable';

    public static function fromString(string $type): self
    {
        return match (strtolower($type)) {
            'fruit' => self::FRUIT,
            'vegetable' => self::VEGETABLE,
            default => throw new \InvalidArgumentException("Invalid edible type: $type"),
        };
    }
}

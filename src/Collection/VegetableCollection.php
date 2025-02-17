<?php

namespace App\Collection;

use App\Entity\EdibleInterface;
use App\Entity\Vegetable;

/**
 * @implements EdibleCollectionInterface<Vegetable>
 */
class VegetableCollection implements EdibleCollectionInterface
{
    /** @var array<int, Vegetable> */
    private array $collection = [];

    public function add(EdibleInterface $item): void
    {
        $this->collection[$item->getId() ?? 0] = $item;
    }

    public function remove(int $id): void
    {
        // TODO 2025-02-17: check for existence and throw an error?
        unset($this->collection[$id]);
    }

    public function list(): array
    {
        return $this->collection;
    }
}

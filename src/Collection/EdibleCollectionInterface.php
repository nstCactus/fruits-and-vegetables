<?php

namespace App\Collection;

use App\Entity\EdibleInterface;

/**
 * @template T of EdibleInterface
 */
interface EdibleCollectionInterface
{
    /**
     * @param T $item
     */
    public function add(EdibleInterface $item): void;

    public function remove(int $id): void;

    /**
     * @return array<int, T>
     */
    public function list(): array;
}

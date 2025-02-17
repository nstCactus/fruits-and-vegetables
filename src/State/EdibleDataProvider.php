<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\AbstractEdible;
use App\Entity\EdibleInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @implements ProviderInterface<AbstractEdible>
 */
readonly class EdibleDataProvider implements ProviderInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?EdibleInterface
    {
        $id = $uriVariables['id'] ?? null;

        if (!$id) {
            throw new \RuntimeException('ID is required to resolve the entity.');
        }

        $entity = $this->entityManager->getRepository(AbstractEdible::class)->find($id);

        return $entity instanceof EdibleInterface ? $entity : null;
    }
}

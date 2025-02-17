<?php

namespace App\Repository;

use App\Entity\AbstractEdible;
use App\Entity\Fruit;
use App\Entity\Vegetable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbstractEdible>
 */
class EdibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractEdible::class);
    }

    /**
     * @return Fruit[]
     */
    public function findFruits(): array
    {
        /** @var Fruit[] $fruits */
        $fruits = $this->createQueryBuilder('e')
            ->andWhere('e INSTANCE OF App\Entity\Fruit')
            ->getQuery()
            ->getResult();
        return $fruits;
    }

    /**
     * @return Vegetable[]
     */
    public function findVegetables(): array
    {
        /** @var Vegetable[] $vegetables */
        $vegetables = $this->createQueryBuilder('e')
            ->andWhere('e INSTANCE OF App\Entity\Vegetable')
            ->getQuery()
            ->getResult();
        return $vegetables;
    }
}

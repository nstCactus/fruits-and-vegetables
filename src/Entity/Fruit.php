<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
#[ApiResource()]
class Fruit extends AbstractEdible
{
}

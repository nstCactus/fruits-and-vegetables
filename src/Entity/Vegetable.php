<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VegetableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VegetableRepository::class)]
#[ApiResource()]
class Vegetable extends AbstractEdible
{
}

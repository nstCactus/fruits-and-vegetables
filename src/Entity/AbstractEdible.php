<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateEdible;
use App\Entity\Enum\EdibleTypeEnum;
use App\Repository\EdibleRepository;
use App\State\EdibleDataProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

//#[ApiResource]
#[ORM\Entity(repositoryClass: EdibleRepository::class)]
#[ORM\Table(name: 'edible')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/edibles/{id}', provider: EdibleDataProvider::class),
        new GetCollection(uriTemplate: '/edibles'),
        new Post(uriTemplate: '/edibles', controller: CreateEdible::class, ),
        new Delete(uriTemplate: '/edibles/{id}'),
    ],
    formats: ['json' => 'application/json'],
)]
abstract class AbstractEdible implements EdibleInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    protected string $name = '';

    protected ?EdibleTypeEnum $type = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    protected int $quantity = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
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

    #[SerializedName('type')]
    public function getTypeName(): string
    {
        return match (true) {
            $this instanceof Fruit => 'fruit',
            $this instanceof Vegetable => 'vegetable',
            default => 'edible',
        };
    }
}

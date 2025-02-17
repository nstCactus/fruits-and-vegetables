<?php

namespace App\Service;

use App\Collection\FruitCollection;
use App\Collection\VegetableCollection;
use App\DTO\EdibleDTO;
use App\Entity\EdibleInterface;
use App\Entity\Enum\EdibleTypeEnum;
use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Exception\ImportException;
use App\Factory\EdibleFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ImportEdiblesService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private EdibleFactory $edibleFactory,
        private FruitCollection $fruitCollection,
        private VegetableCollection $vegetableCollection,
    ) {}

    /**
     * Create & persist fruit & vegetables from the given JSON file
     * @throws ImportException If the file cannot be imported for whatever reason
     */
    public function import(string $filename): void
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new ImportException("Cannot read file: $filename", ImportException::ERROR_NOT_FOUND);
        }

        $jsonData = file_get_contents($filename);

        try {
            /** @var EdibleDTO[] $items */
            $items = $this->serializer->deserialize((string)$jsonData, EdibleDTO::class . '[]', JsonEncoder::FORMAT);

            foreach ($items as $item) {
                $edible = $this->edibleFactory->create($item);
                $this->addToCollection($edible);
                $this->entityManager->persist($edible);
            }

            $this->entityManager->flush();
        } catch (NotEncodableValueException $e) {
            throw new ImportException(
                "Invalid JSON format: {$e->getMessage()}",
                ImportException::ERROR_MALFORMED,
            );
        }
    }

    private function addToCollection(EdibleInterface $edible): void
    {
        switch ($edible::class) {
            case Vegetable::class:
                $this->vegetableCollection->add($edible);
                break;
            case Fruit::class:
                $this->fruitCollection->add($edible);
                break;
        }
    }
}

<?php

namespace App\Tests\Service;

use App\Entity\Enum\EdibleTypeEnum;
use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Exception\ImportException;
use App\Service\ImportEdiblesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImportEdiblesServiceTest extends KernelTestCase
{
    private ImportEdiblesService $service;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->service = $container->get(ImportEdiblesService::class);
    }

    #[\Override]
    protected function tearDown(): void
    {
        $connection = $this->entityManager->getConnection();
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0;');
        $connection->executeStatement('TRUNCATE edible');
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function testImportSucceedsWithAValidJsonFile(): void
    {
        $jsonFilePath = __DIR__ . '/../../Resources/request.json';

        $this->service->import($jsonFilePath);

        $vegetableRepository = $this->entityManager->getRepository(Vegetable::class);
        $carrot = $vegetableRepository->findOneBy(['name' => 'Carrot']);

        $this->assertNotNull($carrot);
        $this->assertEquals(EdibleTypeEnum::VEGETABLE, $carrot->getType());
        $this->assertEquals(10922, $carrot->getQuantity());
        $this->assertEquals(10, $vegetableRepository->count());


        $fruitRepository = $this->entityManager->getRepository(Fruit::class);
        $apples = $fruitRepository->findOneBy(['name' => 'Apples']);

        $this->assertNotNull($apples);
        $this->assertEquals(EdibleTypeEnum::FRUIT, $apples->getType());
        $this->assertEquals(20000, $apples->getQuantity());
        $this->assertEquals(10, $fruitRepository->count());
    }

    public function testImportFailsWithANonExistingFile(): void
    {
        $jsonFilePath = __DIR__ . '/../../Resources/non-existing.json';
        $this->expectException(ImportException::class);
        $this->expectExceptionMessage("Cannot read file: $jsonFilePath");
        $this->expectExceptionCode(ImportException::ERROR_NOT_FOUND);

        $this->service->import($jsonFilePath);
    }

    public function testImportFailsWithAnInvalidJsonFile(): void
    {
        $jsonFilePath = __DIR__ . '/../../Resources/malformed.json';
        $this->expectException(ImportException::class);
        $this->expectExceptionMessageMatches('/^Invalid JSON format: /');
        $this->expectExceptionCode(ImportException::ERROR_MALFORMED);

        $this->service->import($jsonFilePath);
    }
}

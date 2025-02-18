<?php

namespace App\Tests\Api;

use App\Entity\AbstractEdible;
use App\Entity\Enum\EdibleTypeEnum;
use App\Repository\EdibleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EdibleApiTest extends KernelTestCase
{
    private HttpClientInterface $client;
    private EntityManagerInterface $entityManager;
    private EdibleRepository $edibleRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var HttpClientInterface $httpClient */
        $httpClient = $container->get('test.api_platform.client');
        $this->client = $httpClient;

        $this->entityManager = $container->get(EntityManagerInterface::class);

        /** @var EdibleRepository $repository */
        $repository = $this->entityManager->getRepository(AbstractEdible::class);
        $this->edibleRepository = $repository;
    }

    public function testCreateEdible(): void
    {
        $response = $this->client->request('POST', '/api/edibles', [
            'json' => [
                'name' => 'Potato',
                'type' => 'vegetable',
                'quantity' => 10,
                'unit' => 'kg'
            ],
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $responseData = $response->toArray();
        $this->assertEquals('Potato', $responseData['name']);
        $this->assertEquals('vegetable', $responseData['type']);
        $this->assertEquals(10000, $responseData['quantity']);

        // Verify that the data was saved in the database
        $savedEdible = $this->edibleRepository->find($responseData['id']);
        $this->assertNotNull($savedEdible);
        $this->assertEquals('Potato', $savedEdible->getName());
        $this->assertEquals(EdibleTypeEnum::VEGETABLE, $savedEdible->getType());
        $this->assertEquals(10000, $savedEdible->getQuantity());
    }

    public function testGetEdible(): void
    {
        $response = $this->client->request('GET', '/api/edibles/1', [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = $response->toArray();
        $this->assertEquals('Potato', $responseData['name']);
        $this->assertEquals('vegetable', $responseData['type']);
        $this->assertEquals(10000, $responseData['quantity']);
    }

    public function testDeleteEdible(): void
    {
        $edibleId = 1;

        $response = $this->client->request('DELETE', "/api/edibles/{$edibleId}", [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertNull($this->edibleRepository->find($edibleId));
    }
}

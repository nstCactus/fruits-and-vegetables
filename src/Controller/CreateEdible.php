<?php

namespace App\Controller;

use App\DTO\EdibleDTO;
use App\Factory\EdibleFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateEdible extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly EdibleFactory $edibleFactory,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        // Deserialize the request data into an array
        $data = json_decode($request->getContent(), true);

        assert(is_array($data), new BadRequestHttpException('Unexpected JSON payload'));

        $edibleDto = $this->serializer->deserialize($request->getContent(), EdibleDTO::class, JsonEncoder::FORMAT);
        $edible = $this->edibleFactory->create($edibleDto);

        $edible->setId(234);

        $errors = $this->validator->validate($edible);
        if (count($errors)) {
            return $this->json(['errors' => (string)$errors], 400);
        }

        // Persist the entity
        $this->entityManager->persist($edible);
        $this->entityManager->flush();

        // Return the created entity
        return $this->json($edible, 201);
    }
}

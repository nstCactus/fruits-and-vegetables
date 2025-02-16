<?php

namespace App\Tests\App\Service;

use App\Service\StorageService;
use PHPUnit\Framework\TestCase;

class StorageServiceTest extends TestCase
{
    public function testReceivingRequest(): void
    {
        $filename = 'request.json';
        $request = file_get_contents($filename);

        assert(gettype($request) === 'string', "File not found: $filename");

        $storageService = new StorageService($request);

        $this->assertNotEmpty($storageService->getRequest());
        $this->assertIsString($storageService->getRequest());
    }
}

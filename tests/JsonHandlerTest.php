<?php

use App\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;
use App\Services\JsonHandler;
use App\Validators\JsonDataValidator;
use App\Storage\FileStorage;

class JsonHandlerTest extends TestCase
{
    protected $jsonHandler;
    protected $storage;

    protected function setUp(): void
    {
        $validator = new JsonDataValidator();
        $this->storage = $this->createMock(FileStorage::class);
        $this->jsonHandler = new JsonHandler($validator, $this->storage);
    }

    public function testProcessValidJson()
    {
        $data = ['source' => 'test_source', 'payload' => ['email' => 'test@example.com']];

        $this->storage->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $this->jsonHandler->handle($data);
    }

    public function testProcessInvalidJson()
    {
        $this->expectException(ValidationException::class);
        $invalidData = ['payload' => ['email' => 'test@example.com']]; // Missing "source"
        $this->jsonHandler->handle($invalidData);
    }
}

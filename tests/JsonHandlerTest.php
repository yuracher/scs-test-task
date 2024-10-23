<?php

use App\Exceptions\ValidationException;
use App\Sanitizers\SensitiveDataSanitizer;
use App\Services\JsonHandler;
use App\Storage\FileStorage;
use App\Validators\JsonDataValidator;
use App\Validators\JsonValidator;
use PHPUnit\Framework\TestCase;

class JsonHandlerTest extends TestCase
{
    protected $jsonHandler;
    protected $storage;

    protected function setUp(): void
    {
        $jsonValidator = new JsonValidator();
        $dataValidator = new JsonDataValidator();
        $dataSanitizer = new SensitiveDataSanitizer();
        $this->storage = $this->createMock(FileStorage::class);
        $this->jsonHandler = new JsonHandler(
            $jsonValidator, $dataValidator, $dataSanitizer, $this->storage
        );
    }

    public function testProcessValidJson()
    {
        $data = json_encode(['source' => 'test_source', 'payload' => ['email' => 'test@example.com']]);

        $this->storage->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $this->jsonHandler->handle($data);
    }

    public function testProcessInvalidJson()
    {
        $this->expectException(ValidationException::class);
        $invalidData = json_encode(['payload' => ['email' => 'test@example.com']]); // Missing "source"
        $this->jsonHandler->handle($invalidData);
    }
}

<?php

use PHPUnit\Framework\TestCase;
use App\Storage\FileStorage;

class FileStorageTest extends TestCase
{
    protected $fileStorage;
    protected $filePath = __DIR__ . '/../data';
    protected $storedFilePath;

    protected function setUp(): void
    {
        $this->fileStorage = new FileStorage($this->filePath);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->storedFilePath)) {
            unlink($this->storedFilePath);
        }
    }

    public function testStoreDataInFile()
    {
        $data = ['source' => 'test_source', 'payload' => ['key' => 'value']];
        $this->fileStorage->save($data);
        $storedFilePath = $this->fileStorage->getLastStoredFilePath();
        $this->storedFilePath = $storedFilePath;

        $this->assertFileExists($this->storedFilePath);
        $storedData = file_get_contents($this->storedFilePath);
        $this->assertStringContainsString('test_source', $storedData);
    }
}

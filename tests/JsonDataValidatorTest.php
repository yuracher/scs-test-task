<?php

use PHPUnit\Framework\TestCase;
use App\Validators\JsonDataValidator;

class JsonDataValidatorTest extends TestCase
{
    protected $validator;

    protected function setUp(): void
    {
        $this->validator = new JsonDataValidator();
    }

    public function testValidDataPasses()
    {
        $validData = ['source' => 'test_source', 'payload' => ['key' => 'value']];
        $result = $this->validator->validate($validData);
        $this->assertTrue($result);
    }

    public function testMissingSourceFails()
    {
        $invalidData = ['payload' => ['key' => 'value']];
        $result = $this->validator->validate($invalidData);
        $this->assertFalse($result);
    }

    public function testEmptyPayloadFails()
    {
        $invalidData = ['source' => 'test_source', 'payload' => []];
        $result = $this->validator->validate($invalidData);
        $this->assertFalse($result);
    }
}

<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Sanitizers\Sanitizer;
use App\Storage\DataStorage;
use App\Validators\JsonDataValidator;
use App\Validators\JsonValidator;

readonly class JsonHandler
{
    public function __construct(
        private JsonValidator     $jsonValidator,
        private JsonDataValidator $dataValidator,
        private Sanitizer         $dataSanitizer,
        private DataStorage       $storage
    )
    {
    }

    /**
     * @param string $data
     * @return true[]
     * @throws ValidationException
     */
    public function handle(string $data): array
    {
        if (!$this->jsonValidator->validate($data)) {
            throw new ValidationException('Invalid JSON');
        }

        $data = json_decode($data, true);

        if (!$this->dataValidator->validate($data)) {
            throw new ValidationException('Invalid data');
        }

        $sanitizedData = $this->dataSanitizer->sanitize($data);

        if ($this->storage->save($sanitizedData)) {
            return ['success' => true];
        }

        throw new ValidationException('Failed to save data');
    }
}
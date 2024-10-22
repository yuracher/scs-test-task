<?php

namespace App\Services;

use App\Models\DataStorage;
use App\Validators\JsonDataValidator;
use App\Exceptions\ValidationException;

readonly class JsonHandler
{
    public function __construct(
        private JsonDataValidator $validator,
        private DataStorage       $storage
    )
    {
    }

    /**
     * @param array $data
     * @return true[]
     * @throws ValidationException
     */
    public function handle(array $data): array
    {
        if (!$this->validator->validate($data)) {
            throw new ValidationException('Invalid data');
        }

        $sanitizedData = $this->validator->sanitize($data);

        if ($this->storage->save($sanitizedData)) {
            return ['success' => true];
        }

        throw new ValidationException('Failed to save data');
    }
}
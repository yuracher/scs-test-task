<?php

namespace App\Services;

use App\Models\DataStorage;
use App\Validators\JsonDataValidator;

readonly class JsonHandler
{
    public function __construct(
        private JsonDataValidator $validator,
        private DataStorage       $storage
    )
    {
    }

    public function handle(array $request): array
    {
        if (!$this->validator->validate($request)) {
            return ['error' => 'Invalid data'];
        }

        $sanitizedData = $this->validator->sanitize($request);

        if ($this->storage->save($sanitizedData)) {
            return ['success' => true];
        }

        return ['error' => 'Failed to save data'];
    }
}
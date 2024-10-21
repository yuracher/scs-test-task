<?php

namespace App\Storage;

use App\Models\DataStorage;

readonly class FileStorage implements DataStorage
{
    public function __construct(
        private string $filePath
    )
    {
    }

    public function save(array $data): bool
    {
        return file_put_contents($this->filePath, json_encode($data)) !== false;
    }
}
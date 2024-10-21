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
        $identifier = microtime(true) . '_' . $data['source'];
        $newFilePath = $this->filePath . "/data_{$identifier}.json";

        return file_put_contents($newFilePath, json_encode($data, JSON_UNESCAPED_UNICODE)) !== false;
    }
}
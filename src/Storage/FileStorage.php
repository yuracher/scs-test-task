<?php

namespace App\Storage;

class FileStorage implements DataStorage
{
    private string $lastStoredFilePath;

    public function __construct(
        private readonly string $filePath
    )
    {
    }

    public function save(array $data): bool
    {
        $identifier = microtime(true) . '_' . $data['source'];
        $newFilePath = $this->filePath . "/data_{$identifier}.json";
        $this->lastStoredFilePath = $newFilePath;

        return file_put_contents($newFilePath, json_encode($data, JSON_UNESCAPED_UNICODE)) !== false;
    }

    public function getLastStoredFilePath(): string
    {
        return $this->lastStoredFilePath;
    }
}
<?php

use App\Storage\FileStorage;
use App\Sanitizers\SensitiveDataSanitizer;

return [
    'storage' => [
        'class' => env('STORAGE_CLASS') ?: FileStorage::class,
        'params' => [
            'filePath' => env('STORAGE_FILE_PATH') ?: __DIR__ . '/../../data',
        ],
    ],
    'sanitizer' => [
        'class' => SensitiveDataSanitizer::class,
    ],
];

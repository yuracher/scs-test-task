<?php

return [
    'storage' => [
        'class' => env('STORAGE_CLASS') ?: App\Storage\FileStorage::class,
        'filePath' => env('STORAGE_FILE_PATH') ?: __DIR__ . '/../../data',
    ],
];

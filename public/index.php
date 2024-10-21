<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ApiController;
use App\Services\JsonHandler;
use App\Validators\JsonDataValidator;
use App\Storage\FileStorage;

$controller = new ApiController(
    new JsonHandler(
        new JsonDataValidator(), new FileStorage(__DIR__ . '/../data/data.json')
    )
);

$controller->handleRequest();
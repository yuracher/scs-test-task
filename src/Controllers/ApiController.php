<?php

namespace App\Controllers;

use App\Services\JsonHandler;

readonly class ApiController
{
    public function __construct(
        private JsonHandler $jsonHandler
    )
    {
    }

    public function handleRequest(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $response = $this->jsonHandler->handle($data);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
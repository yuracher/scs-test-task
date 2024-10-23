<?php

namespace App\Controllers;

use App\Services\JsonHandler;
use App\Exceptions\ValidationException;

readonly class ApiController
{
    public function __construct(
        private JsonHandler   $jsonHandler,
    )
    {
    }

    public function handleRequest(): void
    {
        $data = file_get_contents('php://input');

        try {
            $response = $this->jsonHandler->handle($data);
            http_response_code(200);
            echo json_encode($response);
        } catch (ValidationException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
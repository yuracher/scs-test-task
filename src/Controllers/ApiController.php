<?php

namespace App\Controllers;

use App\Services\JsonHandler;
use App\Validators\JsonValidator;
use App\Exceptions\ValidationException;

readonly class ApiController
{
    public function __construct(
        private JsonHandler   $jsonHandler,
        private JsonValidator $jsonValidator
    )
    {
    }

    public function handleRequest(): void
    {
        $data = file_get_contents('php://input');

        if (!$this->jsonValidator->validate($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $parsedData = json_decode($data, true);

        try {
            $response = $this->jsonHandler->handle($parsedData);
            http_response_code(200);
            echo json_encode($response);
        } catch (ValidationException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
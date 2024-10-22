<?php

namespace App\Validators;

class JsonDataValidator
{
    public function validate(array $data): bool
    {
        return isset($data['source']) && !empty($data['payload']);
    }

    public function sanitize(array $data): array
    {
        if (isset($data['payload']['email'])) {
            $data['payload']['email'] = '_SENSITIVE_DATA_REMOVED_';
        }
        return $data;
    }
}
<?php

namespace App\Sanitizers;

class SensitiveDataSanitizer implements Sanitizer
{
    public function sanitize(array $data): array
    {
        if (isset($data['payload']['email'])) {
            $data['payload']['email'] = '_SENSITIVE_DATA_REMOVED_';
        }
        return $data;
    }
}
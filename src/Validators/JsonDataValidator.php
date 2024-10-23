<?php

namespace App\Validators;

class JsonDataValidator
{
    public function validate(array $data): bool
    {
        return isset($data['source']) && !empty($data['payload']);
    }
}
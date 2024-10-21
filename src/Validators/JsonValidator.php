<?php

namespace App\Validators;

class JsonValidator
{
    public function validate(string $json): bool
    {
        return json_validate($json);
    }
}
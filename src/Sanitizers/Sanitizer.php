<?php

namespace App\Sanitizers;

interface Sanitizer
{
    public function sanitize(array $data): array;
}
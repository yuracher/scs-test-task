<?php

namespace App\Models;

interface DataStorage
{
    public function save(array $data): bool;
}
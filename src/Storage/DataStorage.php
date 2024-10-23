<?php

namespace App\Storage;

interface DataStorage
{
    public function save(array $data): bool;
}
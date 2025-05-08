<?php

namespace App\Services;
use App\Models\Author;

interface AuthorServiceInterface
{
    public function store(array $data) : ?Author;

    public function update(int $id, array $data) : ?Author;
}

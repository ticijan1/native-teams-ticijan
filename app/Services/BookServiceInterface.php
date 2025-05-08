<?php

namespace App\Services;

use App\Models\Book;

interface BookServiceInterface
{
    public function store(array $data): Book;

    public function update(int $id, array $data): ?Book;

    public function delete(int $id): bool;
}
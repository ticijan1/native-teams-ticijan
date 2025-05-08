<?php

namespace App\Repositories;

use App\Models\Author;

interface AuthorRepositoryInterface
{
    public function getAll(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function findById(int $id): ?Author;

    public function findByName(string $name): ?Author;

    public function create(array $data): Author;

    public function update(Author $author, array $data): Author;

    public function delete(int $id): bool;

    public function findOrCreateAuthor(string $name): Author;
}

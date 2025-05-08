<?php

namespace App\Repositories;

use App\Models\Book;

interface BookRepositoryInterface
{
    public function getAll(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function findById(int $id): ?Book;

    public function create(array $data): Book;

    public function delete(Book $book): bool;
}

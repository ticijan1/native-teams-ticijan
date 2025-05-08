<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    public function getAll(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Book::with([
                'publisher:id,name',
                'subjects:id,name',
                'authors',
            ])->paginate($perPage);
    }

    public function findById(int $id): ?Book
    {
        return Book::with([
                'publisher:id,name',
                'subjects:id,name',
                'authors',
            ])->find($id);
    }

    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function delete(Book $book): bool
    {
        return $book->delete();
    }
}

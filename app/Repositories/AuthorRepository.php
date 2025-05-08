<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function getAll(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Author::with('books')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Author
    {
        return Author::with('books')->find($id);
    }

    public function findByName(string $name): ?Author
    {
        return Author::where('name', $name)->first();
    }

    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function update(Author $author, array $data): Author
    {
        $author->update($data);

        return $author->refresh();
    }

    public function delete(int $id): bool
    {
        $author = Author::find($id);

        if ($author) {
            return $author->delete();
        }

        return false;
    }

    public function findOrCreateAuthor(string $name): Author
    {
        return Author::firstOrCreate(['name' => $name]);
    }
}

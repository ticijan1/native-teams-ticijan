<?php

namespace App\Services;

use App\Services\IsbnServiceInterface;
use App\Models\Author;
use App\Repositories\AuthorRepositoryInterface;

class AuthorService implements AuthorServiceInterface
{
    /** @var IsbnServiceInterface */
    private $isbnService;

    /** @var AuthorRepositoryInterface */
    private $authorRepository;

    public function __construct(
        IsbnServiceInterface $isbnService,
        AuthorRepositoryInterface $authorRepository
    ) {
        $this->isbnService = $isbnService;
        $this->authorRepository = $authorRepository;
    }

    public function store(array $data): ?Author
    {
        if ($this->authorRepository->findByName($data['name'])) {
            throw new \Exception('Author already exists');
        }
    
        return $this->authorRepository->create($data);
    }

    public function update(int $id, array $data): ?Author
    {
        $author = $this->authorRepository->findById($id);

        if (!$author) {
            throw new \Exception('Author not found');
        }

        $this->authorRepository->update($author, $data);

        return $author;
    }
}

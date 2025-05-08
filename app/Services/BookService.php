<?php

namespace App\Services;

use App\Models\Book;
use App\Services\IsbnServiceInterface;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\PublisherRepositoryInterface;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\SubjectRepositoryInterface;
use Illuminate\Support\Collection;

class BookService implements BookServiceInterface
{
    private IsbnServiceInterface $isbnService;

    private BookRepositoryInterface $bookRepository;

    private PublisherRepositoryInterface $publisherRepository;

    private AuthorRepositoryInterface $authorRepository;

    private SubjectRepositoryInterface $subjectRepository;

    public function __construct(
        IsbnServiceInterface $isbnService,
        BookRepositoryInterface $bookRepository,
        PublisherRepositoryInterface $publisherRepository,
        AuthorRepositoryInterface $authorRepository,
        SubjectRepositoryInterface $subjectRepository,
    ) {
        $this->isbnService = $isbnService;
        $this->bookRepository = $bookRepository;
        $this->publisherRepository = $publisherRepository;
        $this->authorRepository = $authorRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function store(array $data): Book
    {
        $bookDetails = $this->isbnService->searchBook($data['title']);
    
        if (!$bookDetails) {
            throw new \Exception('Book not retrieved');
        }

        $formattedData = $this->extractBookData($bookDetails);
        $publisher = $this->publisherRepository->findOrCreatePublisher($bookDetails['publisher']);
        $formattedData['publisher_id'] = $publisher->id;
        $book = $this->bookRepository->create($formattedData);
    
        if (!empty($bookDetails['subjects'])) {
            $this->addSubjectsToBook($book, $bookDetails['subjects']);
        }

        if (!empty($bookDetails['authors'])) {
            $this->addAuthorsToBook($book, $bookDetails['authors']);
        }
    
        return $book;
    }

    public function update(int $id, array $data): ?Book
    {
        $book = $this->bookRepository->findById($id);
    
        if (!$book) {
            throw new \Exception('Book not found');
        }
    
        $book->update($data);
    
        if (!empty($data['subject_ids'])) {
            $book->subjects()->sync($data['subject_ids']);
        }
    
        if (!empty($data['author_ids'])) {
            $book->authors()->sync($data['author_ids']);
        }
    
        return $book->refresh();
    }

    public function delete(int $id): bool
    {
        $book = $this->bookRepository->findById($id);
    
        if (!$book) {
            throw new \Exception('Book not found');
        }
    
        $subjects = $book->subjects;
    
        $deleted = $this->bookRepository->delete($book);
    
        if ($deleted) {
            $this->deleteNotUsedSubjects($subjects);
        }
    
        return $deleted;
    }

    private function extractBookData(array $bookDetails): array
    {
        return [
            'isbn' => $bookDetails['isbn'],
            'title' => $bookDetails['title'] ?? null,
            'cover_image' => $bookDetails['image'] ?? null,
        ];
    }

    // not the most optimal way to do this, but since a book can have a small number of subjects
    // and simplicity/readability is good, we can keep it this way 
    private function addSubjectsToBook(Book $book, array $subjects): void
    {
        foreach ($subjects as $subjectName) {
            $subject = $this->subjectRepository->findOrCreateSubject($subjectName);
            $book->subjects()->attach($subject->id);
        }
    }

    // not the most optimal way to do this, but since a book can have a small number of authors
    // and simplicity/readability is good, we can keep it this way 
    private function addAuthorsToBook(Book $book, array $authors): void
    {
        foreach ($authors as $authorName) {
            $author = $this->authorRepository->findOrCreateAuthor($authorName);
            $book->authors()->attach($author->id);
        }
    }

    private function deleteNotUsedSubjects(Collection $subjects): void
    {
        foreach ($subjects as $subject) {
            if ($subject->books()->count() === 0) {
                $this->subjectRepository->delete($subject);
            }
        }
    }
}

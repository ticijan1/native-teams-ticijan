<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use App\Services\AuthorService;
use App\Repositories\AuthorRepositoryInterface;
use App\Services\IsbnServiceInterface;
use Mockery;

class AuthorServiceTest extends TestCase
{
    private $authorRepositoryMock;
    private $isbnServiceMock;
    private $authorService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorRepositoryMock = Mockery::mock(AuthorRepositoryInterface::class);
        $this->isbnServiceMock = Mockery::mock(IsbnServiceInterface::class);

        $this->authorService = new AuthorService(
            $this->isbnServiceMock,
            $this->authorRepositoryMock
        );
    }

    public function testStoreCreatesNewAuthor()
    {
        $data = ['name' => 'John Doe'];

        $this->authorRepositoryMock
            ->shouldReceive('findByName')
            ->with('John Doe')
            ->once()
            ->andReturn(null);

        $this->authorRepositoryMock
            ->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn(new Author($data));

        $author = $this->authorService->store($data);

        $this->assertInstanceOf(Author::class, $author);
        $this->assertEquals('John Doe', $author->name);
    }

    public function testStoreThrowsExceptionIfAuthorExists()
    {
        $data = ['name' => 'John Doe'];

        $this->authorRepositoryMock
            ->shouldReceive('findByName')
            ->with('John Doe')
            ->once()
            ->andReturn(new Author($data));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Author already exists');

        $this->authorService->store($data);
    }

    public function testUpdateUpdatesExistingAuthor()
    {
        $data = ['name' => 'Jane Doe'];
        $existingAuthor = new Author(['id' => 1, 'name' => 'John Doe']);
    
        $this->authorRepositoryMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn($existingAuthor);
    
        $this->authorRepositoryMock
            ->shouldReceive('update')
            ->with($existingAuthor, $data)
            ->once()
            ->andReturn($existingAuthor);
    
        $existingAuthor->name = $data['name'];
    
        $updatedAuthor = $this->authorService->update(1, $data);
    
        $this->assertInstanceOf(Author::class, $updatedAuthor);
        $this->assertEquals('Jane Doe', $updatedAuthor->name);
    }

    public function testUpdateThrowsExceptionIfAuthorNotFound()
    {
        $data = ['name' => 'Jane Doe'];

        $this->authorRepositoryMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Author not found');

        $this->authorService->update(1, $data);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

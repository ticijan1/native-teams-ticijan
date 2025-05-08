<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Services\BookServiceInterface;
use App\Repositories\BookRepositoryInterface;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    private BookRepositoryInterface $bookRepository;

    private BookServiceInterface $bookService;

    public function __construct(
        BookServiceInterface $bookService,
        BookRepositoryInterface $bookRepository
    ) {
        $this->bookService = $bookService;
        $this->bookRepository = $bookRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->bookRepository->getAll();

        return response()->json([
            'data' => BookResource::collection($books),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        try {
            $book = $this->bookService->store($request->validated());
    
            return response()->json([
                'message' => 'Book created successfully.',
                'data' => new BookResource($book),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create book.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $book = $this->bookRepository->findById((int) $id);
    
            if (!$book) {
                return response()->json([
                    'message' => 'Book not found.',
                ], 404);
            }
    
            return new BookResource($book);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
        try {
            $book = $this->bookService->update((int) $id, $request->validated());
    
            return response()->json([
                'message' => 'Book updated successfully.',
                'data' => new BookResource($book),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update book.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleted = $this->bookService->delete((int) $id);
    
            if ($deleted) {
                return response()->json([
                    'message' => 'Book deleted successfully.',
                ], 200);
            }
    
            return response()->json([
                'message' => 'Failed to delete book.',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete book.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}

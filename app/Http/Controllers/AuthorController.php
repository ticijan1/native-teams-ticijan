<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;
use App\Services\AuthorServiceInterface;
use App\Repositories\AuthorRepositoryInterface;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{
    protected AuthorServiceInterface $authorService;

    private AuthorRepositoryInterface $authorRepository;

    public function __construct(
        AuthorServiceInterface $authorService,
        AuthorRepositoryInterface $authorRepository
    ) {
        $this->authorService = $authorService;
        $this->authorRepository = $authorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = $this->authorRepository->getAll();

        return response()->json([
            'data' => AuthorResource::collection($authors),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        try {
            $author = $this->authorService->store($request->validated());

            return response()->json([
                'message' => 'Author created successfully.',
                'author' => new AuthorResource($author),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $author = $this->authorRepository->findById((int) $id);

            if ($author) {
                return new AuthorResource($author);
            }

            return response()->json([
                'message' => 'Author not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the author.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, string $id)
    {
        try {
            $updatedAuthor = $this->authorService->update((int) $id, $request->validated());

            return response()->json([
                'message' => 'Author updated successfully.',
                'author' => new AuthorResource($updatedAuthor),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleted = $this->authorRepository->delete((int) $id);

            if ($deleted) {
                return response()->json([
                    'message' => 'Author deleted successfully.',
                ], 200);
            }

            return response()->json([
                'message' => 'Author not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the author.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

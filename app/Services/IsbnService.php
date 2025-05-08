<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IsbnService implements IsbnServiceInterface
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('isbn.api_key');
        $this->apiUrl = config('isbn.api_url');
    }

    public function searchBook(string $query, array $filters = []): ?array
    {
        $response = Http::withHeaders($this->getCommonHeaders())
            ->get("{$this->apiUrl}/books/{$query}", $filters);

        return $response->successful() ? $response->json()['books'][0] : null;
    }

    public function searchAuthor(string $query, array $filters = ['pageSize' => '1']): ?array
    {
        $response = Http::withHeaders($this->getCommonHeaders())
            ->get("{$this->apiUrl}/authors/{$query}", $filters);

        return $response->successful() ? $response->json() : null;
    }

    private function getCommonHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => $this->apiKey,
        ];
    }
}

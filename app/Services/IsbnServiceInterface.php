<?php

namespace App\Services;

interface IsbnServiceInterface
{
    /**
     * Search for books based on a query and optional filters.
     *
     * @param string $query
     * @param array $filters
     * @return array|null
     */
    public function searchBook(string $query, array $filters = []): ?array;

    /**
     * Search for authors based on a query and optional filters.
     *
     * @param string $query
     * @param array $filters
     * @return array|null
     */
    public function searchAuthor(string $query, array $filters = ['pageSize' => '1']): ?array;
}

<?php

namespace App\ETL\Extractors;

use App\ETL\Connection\TmdbConnection;

class MovieExtractor
{
    private string $endpoint = 'discover/movie';


    public function all(array $filters = []): \Generator
    {
        $page = 1;

        $response = $this->byPage($page, $filters);
        $totalPages = $response['total_pages'] ?? 1;

        for ($page = 1; $page <= $totalPages; $page++) {
            $response = $this->byPage($page, $filters);

            foreach ($response['results'] ?? [] as $movie) {
                yield $movie;
            }
        }
    }

    public function byPage(int $page = 1, array $filters = []): array
    {
       
        $params = [
            'sort_by' => 'popularity.desc',
            'page' => $page,
            'language' => 'es-ES',
        ];

        $params = array_merge($params, $filters);

        return TmdbConnection::get($this->endpoint, $params);
    }
}
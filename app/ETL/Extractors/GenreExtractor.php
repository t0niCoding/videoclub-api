<?php

namespace App\ETL\Extractors;

use App\ETL\Connection\TmdbConnection;

class GenreExtractor
{
    private string $endpoint = 'genre/movie/list';
    private string $defaultLanguage = 'es';

    public function getGenres(array $params = [])
    {

        $requestParams = array_merge([
            'language' => $this->defaultLanguage,
        ], $params);

        $response = TmdbConnection::getApi($this->endpoint, $requestParams);

        return $response['genres'] ?? [];
    }
}
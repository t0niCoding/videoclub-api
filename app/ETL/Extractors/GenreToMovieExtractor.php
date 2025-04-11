<?php

namespace App\ETL\Extractors;

use App\ETL\Entities\Movie;

class GenreToMovieExtractor
{
    public function getMoviesWithGenres(): array
    {
        $movies = Movie::all();

        $result = [];

        foreach ($movies as $movie) {
            $genreIds = json_decode($movie->genre_ids, true);

            if (!is_array($genreIds)) {
                $genreIds = [];
            }

            $result[] = [
                'original_id' => $movie->original_id,
                'genre_ids' => $genreIds,
            ];
        }
    
        return $result;
    }
}

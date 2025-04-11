<?php

namespace App\ETL\Transformers;

use App\ETL\Entities\GenreToMovie;

class GenreToMovieTransformer
{
    public function transform(array $data): array
    {
        $relations = [];

        foreach ($data as $movie) {
            foreach ($movie['genre_ids'] as $genre) {
          
                $relations[] = [
                    GenreToMovie::MOVIE_ID => $movie['original_id'],
                    GenreToMovie::GENRE_ID => $genre
                ];
            }
        }

        return $relations;
    }
}
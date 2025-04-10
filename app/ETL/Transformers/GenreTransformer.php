<?php

namespace App\ETL\Transformers;

use App\ETL\Entities\Genre;

class GenreTransformer
{

    public function transform(array $data): array
    {

        $transformedGenres = [];
        foreach ($data as $genre) {
            $transformedGenres[] = [
                Genre::ORIGINAL_ID => $genre['id'],
                Genre::NAME => $genre['name'],
            ];
        }

        return $transformedGenres;
    }
}
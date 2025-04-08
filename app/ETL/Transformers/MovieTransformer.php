<?php

namespace App\ETL\Transformers;

use App\ETL\Entities\Movie;

class MovieTransformer
{
    public function transform(array $data): array
    {
        return [
            Movie::ID => $data['id'],
            Movie::TITLE => $data['title'],
            Movie::ORIGINAL_TITLE => $data['original_title'],
            Movie::GENRES_ID => json_encode($data['genres_id']),
            Movie::OVERVIEW => $data['overview'],
            Movie::RELEASE_DATE => $data['release_date'],
            Movie::POSTER_PATH => $data['poster_path'],
            Movie::BACKDROP_PATH => $data['backdrop_path'],
            Movie::VOTE_AVERAGE => $data['vote_average'],
            Movie::POPULARITY => $data['popularity'],
        ];
    }
}   
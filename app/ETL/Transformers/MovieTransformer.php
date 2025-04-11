<?php

namespace App\ETL\Transformers;

use App\ETL\Entities\Movie;
use Carbon\Carbon;

class MovieTransformer
{
    public function transform(array $data): array
    {
        $releaseDate = $this->validateDate($data['release_date'] ?? null);
        
        return [
            Movie::ORIGINAL_ID => $data['id'],
            Movie::TITLE => $data['title'],
            Movie::ORIGINAL_TITLE => $data['original_title'],
            Movie::GENRE_IDS => isset($data['genre_ids']) ? json_encode($data['genre_ids']) : null,
            Movie::OVERVIEW => $data['overview'] ?? null,
            Movie::RELEASE_DATE => $releaseDate ?? null,
            Movie::POSTER_PATH => $data['poster_path'] ?? null,
            Movie::BACKDROP_PATH => $data['backdrop_path'] ?? null,
            Movie::VOTE_AVERAGE => $data['vote_average'] ?? 0,
            Movie::POPULARITY => $data['popularity'] ?? 0,
        ];
    }

    private function validateDate($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        $formattedDate = Carbon::parse($date)->toDateString();  // 'Y-m-d'

        return $formattedDate ?: null;
    }
}   
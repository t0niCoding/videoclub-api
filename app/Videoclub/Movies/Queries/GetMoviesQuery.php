<?php 

namespace App\Videoclub\Movies\Queries;

use Illuminate\Support\Collection;
use App\ETL\Entities\Movie;

class GetMoviesQuery
{   
    public function query(?int $genre = null, $year = null): Collection            
    {
        $query = Movie::query()
        ->select('id', 'original_id', 'title', 'poster_path', 'release_date');

        if ($genre) {
            $query->where('genres_id', $genre);
        }

        if ($year) {
            $query->whereYear('release_date', $year);
        }

        return $query->get();
    }
}
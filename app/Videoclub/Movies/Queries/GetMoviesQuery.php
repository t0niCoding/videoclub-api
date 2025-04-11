<?php 

namespace App\Videoclub\Movies\Queries;

use Illuminate\Support\Collection;
use App\ETL\Entities\Movie;

class GetMoviesQuery
{   
    public function query(?int $genre = null, $year = null): Collection            
    {
        $query = Movie::query()
            ->select(
                'movies.id',
                'movies.original_id',
                'movies.title',
                'movies.poster_path',
                'movies.release_date',
                'genres.id as genre_id',
                'genres.name as genre_name',
                'movies.overview',
                'movies.vote_average',
                'movies.popularity'
            )
            ->leftJoin('genres', 'movies.genres_id', '=', 'genres.id');

        if ($genre) {
            $query->where('genres.id', $genre);
        }

        if ($year) {
            $query->whereYear('movies.release_date', $year);
        }

        return $query->get();
    }
}
<?php 

namespace App\Videoclub\Movies\Queries; 

use Illuminate\Support\Collection;
use App\ETL\Entities\Movie;

class GetMovieDetailQuery
{
    public function query(int $id): ?array
    {
        $movie = Movie::query()
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
            ->leftJoin('genre_to_movie', 'movies.original_id', '=', 'genre_to_movie.movie_id')
            ->leftJoin('genres', 'genre_to_movie.genre_id', '=', 'genres.original_id')
            ->where('movies.id', $id)
            ->first();

        if (!$movie) {
            return null;
        }

        return [
            'id' => $movie->id,
            'original_id' => $movie->original_id,
            'title' => $movie->title,
            'poster_path' => $movie->poster_path,
            'release_date' => $movie->release_date,
            'overview' => $movie->overview,
            'vote_average' => $movie->vote_average,
            'popularity' => $movie->popularity,
            'genres' => [
                [
                    'genre_id' => $movie->genre_id,
                    'genre_name' => $movie->genre_name
                ]
            ]
        ];
    }
}
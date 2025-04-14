<?php

namespace App\Videoclub\Movies\Queries;

use Illuminate\Support\Collection;
use App\ETL\Entities\Movie;

class GetMoviesQuery
{
    public function query(?int $genre = null, $year = null, ?int $id = null): Collection
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
            ->leftJoin('genre_to_movie', 'movies.original_id', '=', 'genre_to_movie.movie_id')
            ->leftJoin('genres', 'genre_to_movie.genre_id', '=', 'genres.original_id')
            ->distinct();


        if ($genre) {
            $query->where('genres.id', $genre);
        }


        if ($year) {
            $query->whereYear('movies.release_date', $year);
        }


        if ($id) {
            $query->where('movies.id', $id);
        }

        $movies = $query->get();

        return $movies
            ->groupBy('id')
            ->map(function ($group) {
                $movie = $group->first();

                $genres = $group->map(function ($row) {
                    return [
                        'genre_id' => $row->genre_id,
                        'genre_name' => $row->genre_name
                    ];
                })->unique('genre_id')->values();

                return [
                    'id' => $movie->id,
                    'original_id' => $movie->original_id,
                    'title' => $movie->title,
                    'poster_path' => $movie->poster_path,
                    'release_date' => $movie->release_date,
                    'overview' => $movie->overview,
                    'vote_average' => $movie->vote_average,
                    'popularity' => $movie->popularity,
                    'genres' => $genres
                ];
            })
            ->values();
    }
}
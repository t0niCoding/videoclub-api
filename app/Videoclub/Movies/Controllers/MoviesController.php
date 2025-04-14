<?php

namespace App\Videoclub\Movies\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Videoclub\Movies\Queries\GetMoviesQuery;

class MoviesController extends Controller
{
    private GetMoviesQuery $getMoviesQuery;

    public function __construct(GetMoviesQuery $getMoviesQuery)
    {
        $this->getMoviesQuery = $getMoviesQuery;
    }
    public function index(Request $request): array
    {
        $genreId = $request->get('genre_id');
        $releaseYear = $request->get('release_date');
        $movieId = $request->get('movie_id');
     
        $movies = $this->getMoviesQuery->query($genreId, $releaseYear, $movieId);

        return [
            'data' => $movies
        ];
    }
}
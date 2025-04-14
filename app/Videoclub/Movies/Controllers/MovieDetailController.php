<?php 

namespace App\Videoclub\Movies\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Videoclub\Movies\Queries\GetMovieDetailQuery;

class MovieDetailcontroller extends Controller
{
    private GetMovieDetailQuery $getMovieDetailQuery;

    public function __invoke(GetMovieDetailQuery $getMovieDetailQuery)
    {
        $this->getMovieDetailQuery = $getMovieDetailQuery;
    }

    public function index(Request $request): array
    {
        $movieId = $request->get('movie_id');
        $movieDetail = $this->getMovieDetailQuery->query($movieId);

        return [
            'data' => $movieDetail
        ];
    }
}
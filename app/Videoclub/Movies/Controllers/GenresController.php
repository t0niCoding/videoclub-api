<?php

namespace App\Videoclub\Movies\Controllers;

use App\Http\Controllers\Controller;
use App\Videoclub\Movies\Queries\GetGenresQuery;
USE App\Etl\Entities\Genre;
class GenresController extends Controller
{
    private GetGenresQuery $getGenresQuery;
    public function __construct(GetGenresQuery $getGenresQuery)
    {
        $this->getGenresQuery = $getGenresQuery;
    }

    public function index()
    {
        return response()->json([
            'data' => Genre::select('id', 'name')->get()
        ]);
    }
}
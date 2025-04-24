<?php

namespace App\Videoclub\Movies\Queries;

use App\ETL\Entities\Genre;

class GetGenresQuery
{
    public function getGenres()
    {
        return Genre::all(['id', 'name']);
    }
}
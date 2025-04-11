<?php

namespace App\ETL\Entities;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = ['id'];
    
    protected $table = self::TABLE;

    const TABLE = 'movies';

    const ORIGINAL_ID = 'original_id';
    const TITLE = 'title';
    const ORIGINAL_TITLE = 'original_title';
    const GENRES_ID = 'genres_id';
    const OVERVIEW = 'overview';
    const RELEASE_DATE = 'release_date';
    const POSTER_PATH = 'poster_path';
    const BACKDROP_PATH = 'backdrop_path';
    const VOTE_AVERAGE = 'vote_average';
    const POPULARITY = 'popularity';


    const UNIQUE_KEYS = [
        self::ORIGINAL_ID, 
    ];

    const UPDATE_COLUMNS = [
        self::TITLE,
        self::ORIGINAL_TITLE,
        self::GENRES_ID,
        self::OVERVIEW,
        self::RELEASE_DATE,
        self::POSTER_PATH,
        self::BACKDROP_PATH,
        self::VOTE_AVERAGE,
        self::POPULARITY,
    ];


    public function genres()
    {
        return $this->belongsToMany(Genre::class, GenreToMovie::TABLE, GenreToMovie::MOVIE_ID, GenreToMovie::GENRE_ID);
    }
}
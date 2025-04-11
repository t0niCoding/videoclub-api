<?php

namespace App\ETL\Entities;

use Illuminate\Database\Eloquent\Model;

class GenreToMovie extends Model
{
    protected $guarded = ['id'];
    protected $table = 'genre_to_movie';

    const TABLE = 'genre_to_movie';

    const GENRE_ID = 'genre_id';
    const MOVIE_ID = 'movie_id';

    const UNIQUE_KEYS = [
        self::GENRE_ID,
        self::MOVIE_ID
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, self::MOVIE_ID);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, self::GENRE_ID);
    }
}
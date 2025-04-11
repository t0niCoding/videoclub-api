<?php

namespace App\ETL\Entities;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = ['id'];

    protected $table = self::TABLE;

    const TABLE = 'genres';

    const ORIGINAL_ID = 'original_id';
    const NAME = 'name';

    const UNIQUE_KEYS = [
        self::ORIGINAL_ID,
    ];

    const UPDATE_COLUMNS = [
        self::NAME,
    ];

    public function movies()
    {
        return $this->belongsToMany(
            Movie::class,
            GenreToMovie::TABLE,
            GenreToMovie::GENRE_ID,
            GenreToMovie::MOVIE_ID,
            Genre::ORIGINAL_ID,
            Movie::ORIGINAL_ID
        );
    }
}
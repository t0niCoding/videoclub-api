<?php

namespace App\ETL\Entities;

use Illuminate\Database\Eloquent\Model;
use const Dom\NAMESPACE_ERR;

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
}
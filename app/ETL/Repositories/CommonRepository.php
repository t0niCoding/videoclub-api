<?php 

namespace App\ETL\Repositories;

use App\Exceptions\CommonRepositoryException;

class CommonRepository
{
    /** 
     * Store data into the database using upsert.
     *
     * @param object $model The model instance.
     * @param array $data The data to be stored.
     * @param array|null $uniqueKeys The unique keys for upsert operation.
     * @param array|null $columns The columns to be updated.
     * 
     * @throws CommonRepositoryException
     */
    public function store($model, $data, $uniqueKeys = null, $columns = null): void
    {
        if (!$columns && !defined($model . '::UPDATE_COLUMNS')) {
            throw new CommonRepositoryException('Columns to update not defined');
        }

        $uniqueKeys = $uniqueKeys ?? $model::UNIQUE_KEYS;
        $columns = $columns ?? $model::UPDATE_COLUMNS;
        $chunkSize = 5000;

        $chunks = array_chunk($data, $chunkSize);

        foreach ($chunks as $chunk) {
            $model::upsert($chunk, $uniqueKeys, $columns);
        }
    }
}
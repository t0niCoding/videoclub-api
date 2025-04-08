<?php 

namespace App\ETL\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CommonRepositoryException;

class CommonRepository
{
    /**
     * Bulk upsert data with optional transaction and logging.
     *
     * @param string $model Eloquent model class.
     * @param array $data Data to upsert.
     * @param array|null $uniqueKeys Defaults to model::UNIQUE_KEYS if not provided.
     * @param array|null $columns Defaults to model::UPDATE_COLUMNS if not provided.
     * @param int $chunkSize Default 5000.
     * @param bool $useTransaction Wrap in a database transaction.
     * @throws CommonRepositoryException
     */

     // Puntos a tener en cuenta de utilizar este CommonRepository:
     // 1. Se debe definir la constante UNIQUE_KEYS en el modelo que se va a utilizar.
     // 2. Se debe definir la constante UPDATE_COLUMNS en el modelo que se va a utilizar.
     // 3. Trabajas con Eloquent.
     // Evitalo si usas MONGODB u otros ORM/DBS no compatibles con upsert
    public function store(
        string $model,
        array $data,
        ?array $uniqueKeys = null,
        ?array $columns = null,
        int $chunkSize = 5000,
        bool $useTransaction = false
    ): void {
        if (!is_subclass_of($model, Model::class)) {
            throw new CommonRepositoryException("{$model} is not a valid Eloquent model.");
        }

        if (empty($data)) {
            Log::warning("Empty data provided for {$model} upsert.");
            return;
        }

        $uniqueKeys = $uniqueKeys ?? (defined("{$model}::UNIQUE_KEYS") ? $model::UNIQUE_KEYS : null);
        $columns = $columns ?? (defined("{$model}::UPDATE_COLUMNS") ? $model::UPDATE_COLUMNS : null);

        if (empty($uniqueKeys)) {
            throw new CommonRepositoryException("No unique keys defined for {$model}.");
        }

        $processChunk = function ($chunk) use ($model, $uniqueKeys, $columns) {
            $model::upsert($chunk, $uniqueKeys, $columns ?? []);
        };

        $chunks = array_chunk($data, $chunkSize);

        try {
            if ($useTransaction) {
                DB::transaction(function () use ($chunks, $processChunk) {
                    foreach ($chunks as $chunk) {
                        $processChunk($chunk);
                    }
                });
            } else {
                foreach ($chunks as $chunk) {
                    $processChunk($chunk);
                }
            }

            Log::info("Upserted " . count($data) . " records into {$model}.");
        } catch (\Exception $e) {
            Log::error("Failed upsert for {$model}: " . $e->getMessage());
            throw new CommonRepositoryException("Database error during upsert: " . $e->getMessage());
        }
    }
}
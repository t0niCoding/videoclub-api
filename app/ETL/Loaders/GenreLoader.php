<?php

namespace App\ETL\Loaders;

use App\ETL\Repositories\CommonRepository;
use App\ETL\Extractors\GenreExtractor;
use App\ETL\Transformers\GenreTransformer;
use App\ETL\Entities\Genre;

class GenreLoader
{
    private GenreExtractor $extractor;
    private GenreTransformer $transformer;
    private CommonRepository $commonRepository;

    public function __construct(
        GenreExtractor $extractor,
        GenreTransformer $transformer,
        CommonRepository $commonRepository
    ) 
    {
        $this->extractor = $extractor;
        $this->transformer = $transformer;
        $this->commonRepository = $commonRepository;
    }

    public function execute(): void
    { 
        $genres = $this->extractor->getGenres();
        $genres = $this->transformer->transform($genres);
        $this->commonRepository->store(Genre::class, $genres, Genre::UNIQUE_KEYS, Genre::UPDATE_COLUMNS);
    }
}
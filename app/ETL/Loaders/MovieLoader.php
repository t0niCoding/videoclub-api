<?php

namespace App\ETL\Loaders;

use App\ETL\Repositories\CommonRepository;
use App\ETL\Extractors\MovieExtractor;
use App\ETL\Transformers\MovieTransformer;
use App\ETL\Entities\Movie;

class MovieLoader
{
    private MovieExtractor $extractor;
    private MovieTransformer $transformer;
    private CommonRepository $commonRepository;

    public function __construct(
        MovieExtractor $extractor,
        MovieTransformer $transformer,
        CommonRepository $repository
    ) {
        $this->extractor = $extractor;
        $this->transformer = $transformer;
        $this->repository = $repository;

    }

    public function execute(): void
    {
        $movies = $this->extractor->getMovies();
        $transformedMovies = [];
        foreach ($movies as $movie) {
            $transformedMovies[] = $this->transformer->transform($movie);
        }
        $this->commonRepository->store(Movie::class, $transformedMovies, Movie::UNIQUE_KEYS, Movie::UPDATE_COLUMNS);
    }
}
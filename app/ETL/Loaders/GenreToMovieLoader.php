<?php

namespace App\ETL\Loaders;

use App\ETL\Repositories\CommonRepository;
use App\ETL\Extractors\GenreToMovieExtractor;
use App\ETL\Transformers\GenreToMovieTransformer;
use App\ETL\Entities\GenreToMovie;

class GenreToMovieLoader
{
    private GenreToMovieExtractor $extractor;
    private GenreToMovieTransformer $transformer;
    private CommonRepository $commonRepository;

    public function __construct(
        GenreToMovieExtractor $extractor,
        GenreToMovieTransformer $transformer,
        CommonRepository $commonRepository
    ) {
        $this->extractor = $extractor;
        $this->transformer = $transformer;
        $this->commonRepository = $commonRepository;
    }

    public function execute(): void
    {
        $moviesWithGenres = $this->extractor->getMoviesWithGenres();

        $moviesAndGenres = $this->transformer->transform($moviesWithGenres);

        $this->commonRepository->store(GenreToMovie::class, $moviesAndGenres, GenreToMovie::UNIQUE_KEYS, []);
    }
}
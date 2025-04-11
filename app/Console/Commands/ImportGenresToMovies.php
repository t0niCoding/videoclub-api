<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ETL\Loaders\GenreToMovieLoader;

class ImportGenresToMovies extends Command
{
    private $GenreToMovieLoader;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:genre-to-movie';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import genre to movie relationships from database';

    /**
     * Execute the console command.
     */

     public function __construct(GenreToMovieLoader $loader)
     {
         parent::__construct();
         $this->GenreToMovieLoader = $loader;
     }
     public function handle()
     {
         $this->info('Importing genre to movie relationships...');
         $this->GenreToMovieLoader->execute();
         $this->info('Import completed successfully!');
     }
}

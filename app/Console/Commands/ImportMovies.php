<?php

namespace App\Console\Commands;

use App\ETL\Loaders\MovieLoader;
use Illuminate\Console\Command;

class ImportMovies extends Command
{
    /**
     * The MovieLoader instance.
     *
     * @var MovieLoader
     */
    private $MovieLoader;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import movies from TMDB';

    /**
     * Execute the console command.
     */

    public function __construct(MovieLoader $loader)
    {
        parent::__construct();
        $this->MovieLoader = $loader;
    }
    public function handle()
    {
        $this->info('Importing movies from TMDB...');
        $this->MovieLoader->execute();
    }
}

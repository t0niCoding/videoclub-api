<?php

namespace App\Console\Commands;

use App\ETL\Loaders\GenreLoader;
use Illuminate\Console\Command;

class ImportGenres extends Command
{
    private $GenreLoader; 
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import genres from TMDB';

    /**
     * Execute the console command.
     */

    public function __construct(GenreLoader $loader)
    {
        parent::__construct();
        $this->GenreLoader = $loader;
    }
    public function handle()
    {
        $this->info('Importing genres from TMDB...');
        $this->GenreLoader->execute();  
    }
}

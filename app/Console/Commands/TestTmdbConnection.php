<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ETL\Connection\TmdbConnection;


class TestTmdbConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test TMDB API Connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $response = TmdbConnection::getApi('/discover/movie');
            $this->info('Conexión exitosa. Primer resultado:');
            $this->line(print_r($response['results'][0], true));
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}

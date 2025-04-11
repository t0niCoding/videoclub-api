<?php

use App\ETL\Entities\GenreToMovie;
use App\ETL\Entities\Movie;
use App\ETL\Entities\Genre;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(GenreToMovie::TABLE, function (Blueprint $table) {
            $table->id(); 
            $table->string(GenreToMovie::MOVIE_ID);
            $table->string(GenreToMovie::GENRE_ID);
            $table->timestamps();

            // Claves foráneas
            $table->foreign(GenreToMovie::MOVIE_ID)
                ->references(Movie::ORIGINAL_ID)
                ->on(Movie::TABLE)
                ->onDelete('cascade');

            $table->foreign(GenreToMovie::GENRE_ID)
                ->references(Genre::ORIGINAL_ID)
                ->on(Genre::TABLE)
                ->onDelete('cascade');

            $table->unique([GenreToMovie::MOVIE_ID, GenreToMovie::GENRE_ID]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(GenreToMovie::TABLE);
    }
};

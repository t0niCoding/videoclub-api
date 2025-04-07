<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use app\ETL\Entities\Movie\Movie;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Movie::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Movie::ORIGINAL_ID)->unique():
            $table->string(Movie::TITLE);
            $table->string(Movie::ORIGINAL_TITLE);
            $table->json(Movie::GENRES_ID)->nullable();
            $table->text(Movie::OVERVIEW)->nullable();
            $table->date(Movie::RELEASE_DATE)->nullable();
            $table->string(Movie::POSTER_PATH)->nullable();
            $table->string(Movie::BACKDROP_PATH)->nullable();
            $table->float(Movie::VOTE_AVERAGE)->nullable();
            $table->float(Movie::POPULARITY)->nullable();
           
            $table->unique(Movie::UNIQUE_KEYS, Movie::TABLE . '_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Movie::TABLE);
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\ETL\Entities\Genre;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Genre::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Genre::ORIGINAL_ID)->unique();
            $table->string(Genre::NAME);
            $table->unique(Genre::UNIQUE_KEYS, Genre::TABLE . '_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Genre::TABLE);
    }
};

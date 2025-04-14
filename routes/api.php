<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Videoclub\Movies\Controllers\MoviesController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/movies', [MoviesController::class, 'index']);

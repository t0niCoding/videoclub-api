<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Videoclub\Movies\Controllers\MoviesController;
use App\Videoclub\Movies\Controllers\MovieDetailcontroller;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/movies', [MoviesController::class, 'index']);
Route::get('/movies{id}', [MovieDetailcontroller::class, 'index']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Videoclub\Movies\Controllers\MoviesController;
use App\Videoclub\Movies\Controllers\MovieDetailcontroller;
use App\Videoclub\Movies\Controllers\GenresController;
use App\Http\Controllers\Auth\AuthController;
use app\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas de login y registro
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Rutas de Google Login
Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/callback', [AuthController::class, 'handleGoogleCallback']);

// Rutas de perfil y logout
Route::get('/me', [LoginController::class, 'me'])->middleware('auth:sanctum'); 
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

// Rutas para películas y géneros
Route::get('/movies', [MoviesController::class, 'index']);
Route::get('/movies/{id}', [MovieDetailController::class, 'index']);
Route::get('/genres', [GenresController::class, 'index']);

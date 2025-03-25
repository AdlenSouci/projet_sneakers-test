<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Models\User;
use App\Models\Marque;
use App\Models\Couleur;
use App\Models\Famille;

use App\Http\Controllers\API\FamilleController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\MarqueController;
use App\Http\Controllers\API\CouleurController;
use App\Http\Controllers\API\AnnonceController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

// Articles
Route::get('/article', [ArticleController::class, 'index']);
Route::post('/article', [ArticleController::class, 'store']);
Route::put('/article/{id}', [ArticleController::class, 'update']);
Route::delete('/article/{id}', [ArticleController::class, 'destroy']);

// Familles
Route::get('/famille', [FamilleController::class, 'index']);
Route::post('/famille', [FamilleController::class, 'store']);
Route::put('/famille/{id}', [FamilleController::class, 'update']);
Route::delete('/famille/{id}', [FamilleController::class, 'destroy']);

// Marques
Route::get('marque', [MarqueController::class, 'index']);
Route::post('marque', [MarqueController::class, 'store']);
Route::put('marque/{id}', [MarqueController::class, 'update']);
Route::delete('marque/{id}', [MarqueController::class, 'destroy']);

// Couleurs
Route::get('couleur', [CouleurController::class, 'index']);
Route::post('couleur', [CouleurController::class, 'store']);
Route::put('couleur/{id}', [CouleurController::class, 'update']);
Route::delete('couleur/{id}', [CouleurController::class, 'destroy']);

// Annonces
Route::get('annonce', [AnnonceController::class, 'index']);
Route::post('annonce', [AnnonceController::class, 'store']);
Route::put('annonce/{id}', [AnnonceController::class, 'update']);
Route::delete('annonce/{id}', [AnnonceController::class, 'destroy']);

Route::get('/user', function (Request $request) {
    return response()->json(User::all());
});

Route::post('/login', [AuthController::class, 'login']);





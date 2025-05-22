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
use App\Http\Controllers\API\CommandeController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AvisController;




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
Route::post('/article/{id}/tailles', [ArticleController::class, 'ajouterTailles']);


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

//users
Route::get('/users', [UserController::class, 'index']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::post('/users', [UserController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);

//route api pour les avis
Route::get('avis', [AvisController::class, 'index']);
Route::post('avis', [AvisController::class, 'store']);
Route::put('avis/{id}', [AvisController::class, 'update']);
Route::delete('avis/{id}', [AvisController::class, 'destroy']); 
Route::put('/avis/{id}/repondre', [AvisController::class, 'repondre']);

//route commandes 


Route::get('/commandes', [CommandeController::class, 'index']);
Route::post('/commandes', [CommandeController::class, 'store']);
Route::put('/commandes/{id}', [CommandeController::class, 'update']);

Route::delete('/commandes/{id}', [CommandeController::class, 'destroy']);


//middleware route api pour les commandes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/commandes', [CommandeController::class, 'index']);
    Route::post('/commandes', [CommandeController::class, 'store']);
    Route::put('/commandes/{id}', [CommandeController::class, 'update']);
    Route::delete('/commandes/{id}', [CommandeController::class, 'destroy']);
});

//middleware route api pour les annonces
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/annonces', [AnnonceController::class, 'index']);
    Route::post('/annonces', [AnnonceController::class, 'store']);
    Route::put('/annonces/{id}', [AnnonceController::class, 'update']);
    Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy']);
});

//middleware route api pour les articles
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
});

//middleware route api pour les familles
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/familles', [FamilleController::class, 'index']);
    Route::post('/familles', [FamilleController::class, 'store']);
    Route::put('/familles/{id}', [FamilleController::class, 'update']);
    Route::delete('/familles/{id}', [FamilleController::class, 'destroy']);
});

//middleware route api pour les marques
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/marques', [MarqueController::class, 'index']);
    Route::post('/marques', [MarqueController::class, 'store']);
    Route::put('/marques/{id}', [MarqueController::class, 'update']);
    Route::delete('/marques/{id}', [MarqueController::class, 'destroy']);
});

//middleware route api pour les couleurs
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/couleurs', [CouleurController::class, 'index']);
    Route::post('/couleurs', [CouleurController::class, 'store']);
    Route::put('/couleurs/{id}', [CouleurController::class, 'update']);
    Route::delete('/couleurs/{id}', [CouleurController::class, 'destroy']);
}); 

//middleware route api pour les users
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});






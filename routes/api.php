<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\FamilleController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
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



// Articles
Route::get('/article', [ArticleController::class, 'index']);
//route middleware similaire au route
Route::middleware('auth:sanctum')->post('/article', [ArticleController::class, 'store']);
Route::middleware('auth:sanctum')->put('/article/{id}', [ArticleController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/article/{id}', [ArticleController::class, 'destroy']);
Route::middleware('auth:sanctum')->post('/article/{id}/tailles', [ArticleController::class, 'ajouterTailles']);



// Familles
Route::get('/famille', [FamilleController::class, 'index']);
// Route::middleware('auth:sanctum')->get('/famille', [FamilleController::class, 'index']); 
Route::middleware('auth:sanctum')->post('/famille', [FamilleController::class, 'store']);
Route::middleware('auth:sanctum')->put('/famille/{id}', [FamilleController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/famille/{id}', [FamilleController::class, 'destroy']);

// Marques
Route::get('marque', [MarqueController::class, 'index']);
Route::middleware('auth:sanctum')->post('marque', [MarqueController::class, 'store']);
Route::middleware('auth:sanctum')->put('marque/{id}', [MarqueController::class, 'update']);
Route::middleware('auth:sanctum')->delete('marque/{id}', [MarqueController::class, 'destroy']);

// Couleurs
Route::get('couleur', [CouleurController::class, 'index']);
Route::middleware('auth:sanctum')->post('couleur', [CouleurController::class, 'store']);
Route::middleware('auth:sanctum')->put('couleur/{id}', [CouleurController::class, 'update']);
Route::middleware('auth:sanctum')->delete('couleur/{id}', [CouleurController::class, 'destroy']);

// Annonces
Route:
Route::middleware('auth:sanctum')->post('annonce', [AnnonceController::class, 'store']);
Route::middleware('auth:sanctum')->put('annonce/{id}', [AnnonceController::class, 'update']);
Route::middleware('auth:sanctum')->delete('annonce/{id}', [AnnonceController::class, 'destroy']);

//users
Route::get('/user', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->post('/user', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->put('/user/{id}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/user/{id}', [UserController::class, 'destroy']);

Route::post('/login', [AuthController::class, 'login']);


//route api pour les avis
Route::get('avis', [AvisController::class, 'index']);
//route post
Route::middleware('auth:sanctum')->post('avis', [AvisController::class, 'store']);
Route::middleware('auth:sanctum')->put('avis/{id}', [AvisController::class, 'update']);
Route::middleware('auth:sanctum')->delete('avis/{id}', [AvisController::class, 'destroy']);
Route::middleware('auth:sanctum')->put('/avis/{id}/repondre', [AvisController::class, 'repondre']);



//route commandes 


Route::get('/commandes', [CommandeController::class, 'index']);
Route::middleware('auth:sanctum')->post('/commandes', [CommandeController::class, 'store']);
Route::middleware('auth:sanctum')->put('/commandes/{id}', [CommandeController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/commandes/{id}', [CommandeController::class, 'destroy']);







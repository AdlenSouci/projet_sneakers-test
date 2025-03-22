<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Models\User;
use App\Models\Marque;
use App\Models\Couleur;
use App\Models\Famille;

use App\Http\Controllers\API\FamillesController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\MarquesController;
use App\Http\Controllers\API\CouleursController;




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


Route::get('/article', [ArticleController::class, 'index']);
Route::post('/article', [ArticleController::class, 'store']);
Route::put('/article/{id}', [ArticleController::class, 'update']);

Route::get('/familles', [FamillesController::class, 'index']);

Route::get('/user', function (Request $request) {
    return response()->json(User::all());
});

Route::post('/login', [AuthController::class, 'login']);


Route::get('marques', [MarquesController::class, 'index']);


Route::delete('marques/{id}', [MarquesController::class, 'destroy']);
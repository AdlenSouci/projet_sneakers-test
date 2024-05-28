<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MailController;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ArticleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('index');

Route::get('/mentions', function () {
    return view('mentions');
})->name('mentions');
Route::get('/cgu', function () {
    return view('cgu');
})->name('cgu');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/test', function () {
    return view('test');
});
Route::post('/test-mail', [MailController::class, 'test'])->name('mail.test');
Route::get('/test-mail', [MailController::class, 'test'])->name('mail.test');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/basket', [BasketController::class, 'index'])->name('basket');
Route::get('/search', [ShopController::class, 'search'])->name('search');

Route::get('/filtre', [ShopController::class, 'filtre'])->name('filtre');
Route::post('/ajouter_au_panier', [BasketController::class, 'ajouter_au_panier'])->name('ajouter_au_panier');

Route::post('/passer-commande', [BasketController::class, 'passerCommande'])->name('passer-commande');//new 22/03/2024
Route::post('/expedier-commande', [BasketController::class, 'expedition'])->name('expedier-commande');

Route::post('/vider-panier', [BasketController::class, 'viderPanier'])->name('viderPanier');
Route::post('/vider-article-panier', [BasketController::class, 'viderArticlePanier'])->name('vider-article-panier');
Route::post('/changer-quantite', [BasketController::class, 'changerQuantite'])->name('changer-quantite');
Route::get('/get-total-price', 'BasketController@calculerPrixTotal');

Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

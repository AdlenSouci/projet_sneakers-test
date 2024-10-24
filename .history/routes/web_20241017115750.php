<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MailController;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AvisController;


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


Route::get('/test', function () {
    return view('test');
});

// Route pour la page de contact
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');

// Route pour le traitement du formulaire de contact
Route::post('/mail/test', [ContactController::class, 'sendMail'])->name('mail.test');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/basket', [BasketController::class, 'index'])->name('basket');
Route::get('/search', [ShopController::class, 'search'])->name('search');

Route::get('/filtre', [ShopController::class, 'filtre'])->name('filtre');
Route::post('/ajouter_au_panier', [BasketController::class, 'ajouter_au_panier'])->name('ajouter_au_panier');


Route::post('/passer-commande', [BasketController::class, 'passerCommande'])->name('passer-commande'); //new 22/03/2024

Route::post('/avis/store', [AvisController::class, 'store'])->name('avis.store');

Route::post('/vider-panier', [BasketController::class, 'viderPanier'])->name('viderPanier');
Route::post('/vider-article-panier', [BasketController::class, 'viderArticlePanier'])->name('vider-article-panier');
Route::post('/changer-quantiter', [BasketController::class, 'changer-quantiter'])->name('changer-quantiter');
Route::get('/get-total-price', 'BasketController@calculerPrixTotal');

Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users/list', [ArticleController::class, 'list'])->name('articles.list');
    Route::resource('articles', ArticleController::class);
    Route::get('/admin/users/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/admin/users', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/admin/users/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/admin/users/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/admin/users/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

require __DIR__ . '/auth.php';

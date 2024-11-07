<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Famille;
use App\Models\Marque;
use App\Models\Couleur;

class ShopController extends Controller
{
    public function index(): View
    {

        $articlesData = Article::with('avis')->get();

        $familles = Famille::all();
        $marques = Marque::all();
        $couleurs = Couleur::all();

        return view('shop', compact('articlesData', 'marques', 'familles', 'couleurs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articlesData'));
    }
    public function filter(Request $request)
{
    $marque = $request->input('marque');
    $famille = $request->input('famille');
    $couleur = $request->input('couleur');

    if (!$marque || !$famille || !$couleur) {
        return response()->json(['error' => 'Paramètres manquants'], 400);
    }

    $articles = Article::where('nom_marque', $marque)
        ->where('nom_famille', $famille)
        ->where('nom_couleur', $couleur)
        ->get();

    return response()->json(['articles' => $articles]);
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Famille;
use App\Models\Marque;
use App\Models\Couleur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    

    $query = Article::query();

    // Appliquer le filtre pour la marque
    if ($request->has('marque') && !empty($request->input('marque'))) {
        $query->where('nom_marque', 'like', '%' . $request->input('marque') . '%');
    }

    // Appliquer le filtre pour la famille
    if ($request->has('famille') && !empty($request->input('famille'))) {
        $query->where('nom_famille', 'like', '%' . $request->input('famille') . '%');
    }

    // Appliquer le filtre pour la couleur
    if ($request->has('couleur') && !empty($request->input('couleur'))) {
        $query->where('nom_couleur', 'like', '%' . $request->input('couleur') . '%');
    }

    // Appliquer le filtre pour le prix
    if ($request->has('prix') && !empty($request->input('prix'))) {
        $priceRange = explode('-', $request->input('prix'));
        if (count($priceRange) == 2) {
            $query->whereBetween('prix_public', [$priceRange[0], $priceRange[1]]);
        } elseif ($request->input('prix') == '500') {
            $query->where('prix_public', '>=', 500);
        }
    }

    // Exécuter la requête pour obtenir les articles filtrés
    $articles = $query->get();

    // Récupérer les valeurs disponibles pour les filtres
    $availableMarques = Article::distinct()->pluck('nom_marque')->toArray();
    $availableFamilles = Article::distinct()->pluck('nom_famille')->toArray();
    $availableCouleurs = Article::distinct()->pluck('nom_couleur')->toArray();

    return view('shop', compact('articles', 'availableMarques', 'availableFamilles', 'availableCouleurs'));
}

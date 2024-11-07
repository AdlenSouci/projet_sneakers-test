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

   //filtre de produit par famille
    public function filtre(Request $request)
    {   
        $familles = Famille::all();
        $marques = Marque::all();
        $couleurs = Couleur::all();
        $articlesData = Article::with('avis')->get();
        $selectedFamille = $request->input('famille');
        $selectedMarque = $request->input('marque');
        $selectedCouleur = $request->input('couleur');
        $articlesData = $articlesData->filter(function ($article) use ($selectedFamille, $selectedMarque, $selectedCouleur) {
            if ($selectedFamille && $selectedFamille !== 'Toutes les familles') {
                return $article->famille->nom_famille === $selectedFamille;
            }
            if ($selectedMarque && $selectedMarque !== 'Toutes les marques') {
                return $article->marque->nom_marque === $selectedMarque;
            }
            if ($selectedCouleur && $selectedCouleur !== 'Toutes les couleurs') {
                return $article->couleur->nom_couleur === $selectedCouleur;
            }
            return true;
        });
        return view('shop', compact('articlesData', 'marques', 'familles', 'couleurs'));
}

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
        $articlesData = Article::with('avis')->get();  // Articles avec avis
        $familles = Famille::all();
        $marques = Marque::all();
        $couleurs = Couleur::all();
        

        return view('shop', compact('articlesData', 'familles', 'marques', 'couleurs'));
    }

    // Méthode pour appliquer les filtres
    public function filtrerArticles(Request $request)
    {
        $query = Article::query();

        if ($request->has('marque') && $request->marque) {
            $query->where('marque_id', $request->marque);
        }

        if ($request->has('couleur') && $request->couleur) {
            $query->where('couleur_id', $request->couleur);
        }

        if ($request->has('prixMin') && $request->prixMin) {
            $query->where('prix_public', '>=', $request->prixMin);
        }

        if ($request->has('prixMax') && $request->prixMax) {
            $query->where('prix_public', '<=', $request->prixMax);
        }

        $articlesData = $query->with('avis')->get();

        return response()->json(['articles' => $articlesData]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articlesData'));
    }
}

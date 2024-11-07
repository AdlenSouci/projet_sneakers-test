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
    public function filter(Request $request): View
    {
        $familles = $request->input('familles');
        $marques = $request->input('marques');
        $couleurs = $request->input('couleurs');
        $prixMin = $request->input('prixMin');
        $prixMax = $request->input('prixMax');

        $articlesData = Article::with('avis')
            ->when($familles, fn($query) => $query->whereIn('id_famille', $familles))
            ->when($marques, fn($query) => $query->whereIn('id_marque', $marques))
            ->when($couleurs, fn($query) => $query->whereIn('id_couleur', $couleurs))
            ->when($prixMin, fn($query) => $query->where('prix_public', '>=', $prixMin))
            ->when($prixMax, fn($query) => $query->where('prix_public', '<=', $prixMax))
            ->get();

        return view('shop', compact('articlesData', 'familles', 'marques', 'couleurs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articlesData'));
    }

    

    
}

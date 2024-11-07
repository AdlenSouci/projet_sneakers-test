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
        // Récupérer les articles avec leurs avis
        $articlesData = Article::with('avis')->get();

        // Récupérer les familles
        $familles = Famille::all();

        // Récupérer les marques
        $marques = Marque::all();

        // Récupérer les couleurs
        $couleurs = Couleur::all();

        // Renvoyer la vue avec les articles et les familles
        return view('shop', compact('articlesData', 'familles', 'marques', 'couleurs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articlesData'));
    }

    

    
}

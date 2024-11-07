<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Famille;
use App\Models\Marque;
use App\Models\Couleur;
use Illuminate\Support\Facades\DB;

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

    public function filterArticles(Request $request)
    {
        // Construire la requête de base
        $query = DB::table('articles');

        // Appliquer les filtres uniquement si des paramètres sont présents dans la requête
        if ($request->has('marque')) {
            $query->where('nom_marque', $request->get('marque'));
        }

        if ($request->has('famille')) {
            $query->where('nom_famille', $request->get('famille'));
        }

        if ($request->has('couleur')) {
            $query->where('nom_couleur', $request->get('couleur'));
        }

        // Exécuter la requête et obtenir les résultats
        $articles = $query->get();

        // Vérifier si des articles ont été trouvés
        if ($articles->isEmpty()) {
            return response()->json(['message' => 'Aucun article trouvé pour ces filtres.'], 404);
        }

        // Retourner les articles trouvés
        return response()->json($articles);
    }
}

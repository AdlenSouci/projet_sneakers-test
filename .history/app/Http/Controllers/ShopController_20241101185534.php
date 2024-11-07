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
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;

    public function filterArticles(Request $request)
    {
        // Construire la requête de base
        $query = DB::table('articles');

        // Appliquer les filtres dynamiquement en fonction des entrées utilisateur
        if ($request->filled('nom_marque')) {
            $query->where('nom_marque', $request->input('nom_marque'));
        }

        if ($request->filled('nom_famille')) {
            $query->where('nom_famille', $request->input('nom_famille'));
        }

        if ($request->filled('nom_couleur')) {
            $query->where('nom_couleur', $request->input('nom_couleur'));
        }

        // Exécuter la requête et obtenir les résultats
        $articles = $query->get();

        // Vérifier si des articles ont été trouvés
        if ($articles->isEmpty()) {
            return response()->json(['message' => 'Aucun résultat trouvé pour ces filtres.'], 404);
        }

        // Retourner les articles trouvés
        return response()->json($articles);
    }
}

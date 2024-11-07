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

    public function filter(Request $request)
    {
        $query = Article::query()->with('avis');

        // Filtre par marque
        if ($request->filled('marque')) {
            $query->whereHas('marque', function ($q) use ($request) {
                $q->where('nom_marque', $request->input('marque'));
            });
        }

        // Filtre par couleur
        if ($request->filled('couleur')) {
            $query->whereHas('couleur', function ($q) use ($request) {
                $q->where('nom_couleur', $request->input('couleur'));
            });
        }

        // Récupère les articles filtrés
        $articlesData = $query->get();

        // Retourne les articles filtrés
        return response()->json([
            'articlesData' => $articlesData,
        ]);
    }
}

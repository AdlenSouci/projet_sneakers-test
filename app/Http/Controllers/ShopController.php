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

        //$familles = Famille::all();
        $familles = Article::with('famille') // Charge la relation "couleur"
            ->get()
            ->pluck('famille') // Récupère les objets couleur associés
            ->unique('id'); // Assure qu'il n'y a pas de doublons par id

        //$marques = Marque::all();
        $marques = Article::with('marque') // Charge la relation "couleur"
            ->get()
            ->pluck('marque') // Récupère les objets couleur associés
            ->unique('id'); // Assure qu'il n'y a pas de doublons par id

        //$couleurs = Couleur::all();
        $couleurs = Article::with('couleur') // Charge la relation "couleur"
            ->get()
            ->pluck('couleur') // Récupère les objets couleur associés
            ->unique('id'); // Assure qu'il n'y a pas de doublons par id

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

        // Filtre par prix min et max
        if ($request->filled('prix_min')) {
            $query->where('prix_public', '>=', $request->input('prix_min'));
        }

        if ($request->filled('prix_max')) {
            $query->where('prix_public', '<=', $request->input('prix_max'));
        }

        // Tri par prix
        if ($request->filled('prix')) {
            $query->orderBy('prix_public', $request->input('prix'));
        }

        $articlesData = $query->get();

        return response()->json(['articlesData' => $articlesData]);
    }
}

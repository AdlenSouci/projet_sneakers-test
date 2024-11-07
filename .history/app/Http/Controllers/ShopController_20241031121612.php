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
        $articlesData = Article::query()->with('avis'); 

        // Filter by marque
        if ($request->has('marque') && !empty($request->input('marque'))) {
            $articlesData->where('nom_marque', $request->input('marque'));
        }

        // Filter by famille
        if ($request->has('famille') && !empty($request->input('famille'))) {
            $articlesData->where('id_famille', $request->input('famille'));
        }

        // Filter by couleur
        if ($request->has('couleur') && !empty($request->input('couleur'))) {
            $articlesData->where('nom_couleur', $request->input('couleur'));
        }

        // Filter by price
        if ($request->has('prix_min') && !empty($request->input('prix_min')) && $request->has('prix_max') && !empty($request->input('prix_max'))) {
            $articlesData->whereBetween('prix_public', [
                (float) $request->input('prix_min'),
                (float) $request->input('prix_max')
            ]);
        }

        // Obtenir les résultats filtrés
        $articlesData = $articlesData->get();

        return response()->json(['articles' => $articlesData]);
    }
}

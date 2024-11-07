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
        $query = Article::query();

        if ($request->filled('marque')) {
            $query->where('nom_marque', $request->input('marque'));
        }

        if ($request->filled('famille')) {
            $query->where('nom_famille', $request->input('famille'));
        }

        if ($request->filled('couleur')) {
            $query->where('nom_couleur', $request->input('couleur'));
        }

        $articles = $query->get();
        dd($query->toSql(), $query->getBindings());

        return response()->json(['articles' => $articles]);
    }
}

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
        

        return view('shop', compact('articlesData'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articlesData'));
    }

    public function filter(Request $request)
    {
        $articlesData = Article::query();

        // Filter by marque
        if ($request->has('marque')) {
            $articlesData->where('id_marque', $request->input('marque'));
        }

        // Filter by prix
        if ($request->has('prix_min') && $request->has('prix_max')) {
            $articlesData->whereBetween('prix_public', [$request->input('prix_min'), $request->input('prix_max')]);
        }

        // Filter by famille
        if ($request->has('famille')) {
            $articlesData->where('id_famille', $request->input('famille'));
        }

        // Filter by couleur
        if ($request->has('couleur')) {
            $articlesData->where('nom_couleur', $request->input('couleur'));
        }

        $articlesData = $articlesData->with('avis')->get();

        return response()->json(['articles' => $articlesData]);
    }
}

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
    public function index(Request $request): View
{
    $query = Article::with('avis');

    // Filtrage par marque
    if ($request->filled('marque')) {
        $query->whereHas('marque', function ($q) use ($request) {
            $q->where('nom_marque', $request->input('marque'));
        });
    }

    // Filtrage par couleur
    if ($request->filled('couleur')) {
        $query->whereHas('couleur', function ($q) use ($request) {
            $q->where('nom_couleur', $request->input('couleur'));
        });
    }

    // Filtrage par prix
    if ($request->filled('prix')) {
        $order = $request->input('prix') == 'asc' ? 'asc' : 'desc';
        $query->orderBy('prix_public', $order);
    }

    // Récupérer les articles filtrés
    $articlesData = $query->get();

    // Récupérer les autres données (marques, familles, couleurs)
    $marques = Marque::all();
    $couleurs = Couleur::all();

    return view('shop', compact('articlesData', 'marques', 'couleurs'));
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

        // Vérifiez les paramètres de la requête
        \Log::info('Filtres appliqués : ', $request->all());

        // Filtre par marque
        if ($request->filled('marque')) {
            $query->whereHas('marque', function ($q) use ($request) {
                $q->where('nom_marque', $request->input('marque'));
            });
        }


        if ($request->filled('famille')) {
            $query->whereHas('famille', function ($q) use ($request) {
                $q->where('nom_famille', $request->input('famille'));
            });
        }

        if ($request->filled('prix')) {
            $prix = $request->input('prix');
            if ($prix === 'asc') {
                $query->orderBy('prix_public', 'asc');
            } elseif ($prix === 'desc') {
                $query->orderBy('prix_public', 'desc');
            }
        }



        // if ($request->filled('couleur')) {
        //     $query->where('nom_couleur', $request->input('couleur'));
        // }


        // if ($request->filled('prix_min') && $request->filled('prix_max')) {
        //     $query->whereBetween('prix_public', [$request->input('prix_min'), $request->input('prix_max')]);
        // }

        $articlesData = $query->get();

        \Log::info('Résultats des articles : ', $articlesData->toArray());

        return response()->json(['articlesData' => $articlesData]);
    }
}

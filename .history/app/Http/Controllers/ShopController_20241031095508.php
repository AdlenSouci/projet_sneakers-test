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
        $articlesData = Article::with('avis,'marque', 'famille', 'couleur')->get();  // Articles avec avis
        $familles = Famille::all();
        $marques = Marque::all();
        $couleurs = Couleur::all();



        return view('shop', compact('articlesData', 'familles', 'marques', 'couleurs'));
    }

    // Méthode pour appliquer les filtres


    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articlesData'));
    }

    public function filter(Request $request)
    {
        $query = Article::query();

        if ($request->marque) {
            $query->where('nom_marque', $request->marque);
        }
        if ($request->famille) {
            $query->where('nom_famille', $request->famille);
        }
        if ($request->modele) {
            $query->where('modele', 'like', '%' . $request->modele . '%');
        }
        if ($request->couleur) {
            $query->where('nom_couleur', $request->couleur);
        }
        if ($request->prix) {
            $prixRange = explode('-', $request->prix);
            if (count($prixRange) === 2) {
                $query->whereBetween('prix_public', [floatval($prixRange[0]), floatval($prixRange[1])]);
            } elseif ($request->prix === '200+') {
                $query->where('prix_public', '>', 200);
            }
        }

        $articles = $query->get();

        return view('partials.articles', compact('articles'));
    }
}

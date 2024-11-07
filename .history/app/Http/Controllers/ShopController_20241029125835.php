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

    public function filter(Request $request)
    {
        $familles = $request->input('familles');
        $marques = $request->input('marques');
        $couleurs = $request->input('couleurs');

        $articlesData = Article::with('avis')

            ->when($familles, function ($query) use ($familles) {
                $query->whereIn('id_famille', $familles);
            })
            ->when($marques, function ($query) use ($marques) {
                $query->whereIn('id_marque', $marques);
            })
            ->when($couleurs, function ($query) use ($couleurs) {
                $query->whereIn('id_couleur', $couleurs);
            })
            ->get();

        return view('shop', compact('articlesData'));
    }

    public function filtrerParMarque(Request $request)
    {
        $marque = $request->input('nom');
        $marques = Marque::where('nom_marque', $marque)->pluck('nom_marque');
        return response()->json(['marques' => $marques]);
    }

    public function filtrerParPrix(Request $request)
    {
        $prixMin = $request->input('prixMin');
        $prixMax = $request->input('prixMax');

        $articlesData = Article::with('avis')
            ->when($prixMin, function ($query) use ($prixMin) {
                $query->where('prix_public', '>=', $prixMin);
            })
            ->when($prixMax, function ($query) use ($prixMax) {
                $query->where('prix_public', '<=', $prixMax);
            })
            ->get();

        return view('shop', compact('articlesData'));
    }

    public function filtrerParFamille(Request $request)
    {
        $famille = $request->input('famille');
        $articles = Article::where('id_famille', $famille)->get();
        $familles = Famille::all(); // Récupérer les familles
        return view('shop', compact('articles', 'nom_famille'));
    }

    public function filtrerParCouleur(Request $request)
    {
        $couleur = $request->input('couleur');
        $articles = Article::where('id_couleur', $couleur)->get();
        $couleurs = Couleur::all(); // Récupérer les couleurs
        return view('shop', compact('articles', 'couleurs')); // Passer les couleurs à la vue
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Famille;
use App\Models\Marque;
use App\Models\Couleur;

class ArticleController extends Controller
{
    // Affiche un article spécifique
    public function show($id)
    {
        $article = Article::findOrFail($id);
      
        return view('article', compact('article'));

    }

    // Affiche la liste des articles
    public function list()
    {
        $articles = Article::all();
        return view('admin.users.list', compact('articles'));
    }

    // Affiche le formulaire de création d'un nouvel article
    public function create()
    {
        $familles = Famille::all();
        $marques = Marque::all();
        $couleurs = Couleur::all();
        return view('admin.users.create', compact('familles', 'marques', 'couleurs'));
    }

    // Stocke un nouvel article
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'id_famille' => 'required|exists:familles,id',
            'nom_marque' => 'required|string', // Correspond à l'attribut du formulaire
            'modele' => 'required|string|max:70',
            'description' => 'nullable|string',
            'id_couleur' => 'required|exists:couleurs,id',
            'prix_public' => 'required|numeric',
            'prix_achat' => 'required|numeric',
            'img' => 'required|string',
        ]);

        // Récupération de la marque et de la couleur
        $marque = Marque::where('nom_marque', $request->nom_marque)->firstOrFail();
        $couleur = Couleur::findOrFail($request->id_couleur);

        // Création de l'article
        $article = new Article();
        $article->id_famille = $request->id_famille;
        $article->nom_famille = Famille::find($request->id_famille)->nom_famille; // Ajoute cette ligne pour obtenir le nom de la famille
        $article->id_marque = $marque->id; // Utilisation de l'ID de la marque
        $article->nom_marque = $marque->nom_marque; // Utilisation du nom de la marque
        $article->modele = $request->modele;
        $article->description = $request->description;
        $article->nom_couleur = $couleur->nom_couleur; // Utilisation du nom de la couleur
        $article->prix_public = $request->prix_public;
        $article->prix_achat = $request->prix_achat;
        $article->img = $request->img;
        $article->save();

        // Redirection avec message de succès
        return redirect()->route('articles.list')->with('success', 'Article ajouté avec succès !');
    }


    public function edit(Article $article)
    {
        $familles = Famille::all();
        $marques = Marque::all();
        $couleurs = Couleur::all();
        return view('admin.users.edit', compact('article', 'familles', 'marques', 'couleurs'));
    }


    // Met à jour un article existant
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'id_famille' => 'required|exists:familles,id',
            'id_marque' => 'required|exists:marques,id',
            'modele' => 'required|string|max:70',
            'description' => 'nullable|string',
            'id_couleur' => 'required|exists:couleurs,id',
            'prix_public' => 'required|numeric',
            'prix_achat' => 'required|numeric',
            'img' => 'required|string',
            'nom_marque' => 'required|string',
        ]);

        // Récupération de la couleur
        $couleur = Couleur::findOrFail($validated['id_couleur']);

        // Utilisez le nom de la marque du formulaire pour mettre à jour l'article
        $article->update([
            'id_famille' => $validated['id_famille'],
            'id_marque' => $validated['id_marque'],
            'nom_marque' => $validated['nom_marque'], // Mise à jour de nom_marque
            'modele' => $validated['modele'],
            'description' => $validated['description'],
            'nom_couleur' => $couleur->nom_couleur, // Mise à jour de nom_couleur
            'prix_public' => $validated['prix_public'],
            'prix_achat' => $validated['prix_achat'],
            'img' => $validated['img'],
        ]);

        return redirect()->route('articles.list')->with('success', 'Article mis à jour avec succès !');
    }



    // Supprime un article
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.list')->with('success', 'Article supprimé avec succès !');
    }


    
}

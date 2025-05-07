<?php

namespace App\Http\Controllers\API;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    // Récupérer tous les articles
    public function index()
    {
        $articles = Article::with(['tailles'])->get()->makeHidden(['famille', 'marque', 'couleur']);
        return response()->json($articles);
    }

    // Ajouter un nouvel article
    public function store(Request $request)
{
    // Validation des données
    $validator = Validator::make($request->all(), [
        'modele' => 'required|string|max:255',
        'description' => 'nullable|string',
        'prix_public' => 'required|numeric',
        'prix_achat' => 'required|numeric',
        'img' => 'nullable|string|max:255',
        'id_famille' => 'required|integer',
        'id_couleur' => 'nullable|integer',
        'id_marque' => 'required|integer',
        'tailles' => 'required|array', // tableau de tailles avec stock
        'tailles.*.taille' => 'required|integer',
        'tailles.*.stock' => 'required|integer|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Vérification de l'existence de l'article
    $existingArticle = Article::where('modele', $request->modele)
        ->where('id_famille', $request->id_famille)
        ->where('id_marque', $request->id_marque)
        ->first();

    if ($existingArticle) {
        return response()->json(['error' => 'Un article avec les mêmes attributs existe déjà.'], 409);
    }

    try {
        // Création de l'article
        $article = Article::create($request->only([
            'modele', 'description', 'prix_public', 'prix_achat',
            'img', 'id_famille', 'id_couleur', 'id_marque'
        ]));

        // Création des tailles associées
        foreach ($request->tailles as $tailleData) {
            $article->tailles()->create([
                'taille' => $tailleData['taille'],
                'stock' => $tailleData['stock'],
            ]);
        }

    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la création de l\'article. ' . $e->getMessage()], 500);
    }

    return response()->json($article->load('tailles'), 201);
}


    // Méthode pour mettre à jour un article (si nécessaire)
    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'modele' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix_public' => 'required|numeric',
            'prix_achat' => 'required|numeric',
            'img' => 'nullable|string|max:255',
            'id_famille' => 'required|integer',
            'id_couleur' => 'nullable|integer',
            'id_marque' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article non trouvé.'], 404);
        }
        $output = new ConsoleOutput();
        $output->writeln($article);

        // Mise à jour de l'article
        try {
            $article->update($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de l\'article.'], 500);
        }

        return response()->json($article, 200);
    }

    public function destroy($id)
    {

        // Trouver l'article par son ID

        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article non trouvé.'], 404);
        }

        // Suppression de l'article
        try {
            $article->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de l\'article.'], 500);
        }

        return response()->json(['message' => 'Article supprimé avec succès.'], 200);
    }
}

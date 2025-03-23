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
        $articles = Article::with(['famille', 'marque', 'couleur'])->get()->makeHidden(['famille', 'marque', 'couleur']); // Cache les objets famille, marque et couleur;
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
            'id_famille' => 'required|integer', // Validation pour id_famille
            'id_couleur' => 'nullable|integer', // Validation pour id_couleur,
            'id_marque' => 'required|integer', // Validation pour id_marque
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Création de l'article
        try {
            $article = Article::create($request->all());

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création de l\'article. ' . $e->getMessage()], 500);
        }

        return response()->json($article, 201);
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
            'id_famille' => 'required|integer', // Validation pour id_famille
            'id_couleur' => 'nullable|integer', // Validation pour id_couleur,
            'id_marque' => 'required|integer', // Validation pour id_marque
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

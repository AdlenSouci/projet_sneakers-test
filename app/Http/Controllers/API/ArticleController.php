<?php

namespace App\Http\Controllers\API;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\TaillesArticle;

class ArticleController extends Controller
{
  
    public function index()
    {
        $articles = Article::with(['tailles'])->get()->makeHidden(['famille', 'marque', 'couleur']);
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modele' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix_public' => 'required|numeric',
            'prix_achat' => 'required|numeric',
            'img' => 'nullable|string|max:255',
            'id_famille' => 'required|integer',
            'id_couleur' => 'nullable|integer',
            'id_marque' => 'required|integer',
            'tailles' => 'required|array', // <-- Reste required ici, comme dans votre code
            'tailles.*.taille' => 'required|integer',
            'tailles.*.stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $existingArticle = Article::where('modele', $request->modele)
            ->where('id_famille', $request->id_famille)
            ->where('id_marque', $request->id_marque)
            ->first();

        if ($existingArticle) {
            return response()->json(['error' => 'Un article avec les mêmes attributs existe déjà.'], 409);
        }

        try {
            $article = Article::create($request->only([
                'modele',
                'description',
                'prix_public',
                'prix_achat',
                'img',
                'id_famille',
                'id_couleur',
                'id_marque'
            ]));

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

    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article non trouvé.'], 404);
        }

        $validatorArticle = Validator::make($request->all(), [
            'modele' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix_public' => 'required|numeric',
            'prix_achat' => 'required|numeric',
            'img' => 'nullable|string|max:255',
            'id_famille' => 'required|integer',
            'id_couleur' => 'nullable|integer',
            'id_marque' => 'required|integer',
            'tailles' => 'array',
            'tailles.*.id' => 'sometimes|integer|nullable',
            'tailles.*.taille' => 'required|integer|min:1',
            'tailles.*.stock' => 'required|integer|min:0',
        ]);

        if ($validatorArticle->fails()) {
            return response()->json($validatorArticle->errors(), 400);
        }

        $existingArticle = Article::where('modele', $request->modele)
            ->where('id_famille', $request->id_famille)
            ->where('id_marque', $request->id_marque)
            ->whereKeyNot($id)
            ->first();

        if ($existingArticle) {
            return response()->json(['error' => 'Un autre article avec les mêmes attributs existe déjà.'], 409);
        }

        try {
            $article->update($request->only([
                'modele',
                'description',
                'prix_public',
                'prix_achat',
                'img',
                'id_famille',
                'id_couleur',
                'id_marque'
            ]));

            $article->tailles()->delete();

            if ($request->has('tailles') && is_array($request->tailles)) {
                foreach ($request->tailles as $sizeData) {
                    $article->tailles()->create([
                        'taille' => $sizeData['taille'],
                        'stock' => $sizeData['stock'],
                    ]);
                }
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de l\'article ou de son stock. ' . $e->getMessage()], 500);
        }

        return response()->json($article->load('tailles'), 200);
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article non trouvé.'], 404);
        }

        try {
            $article->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de l\'article. ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Article supprimé avec succès.'], 200);
    }
}
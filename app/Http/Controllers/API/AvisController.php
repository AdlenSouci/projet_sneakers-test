<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Avis;
use illuminate\Support\Facades\Validator;

class AvisController extends Controller
{

   
    // Récupérer tous les avis
    public function index()
    {
        $avis = Avis::all();
        return response()->json($avis);
    }

    // Ajouter un nouvel avis
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
            'note' => 'required|integer|between:1,5',
            'article_id' => 'required|exists:articles,id',

        ]);

        // Vérifier si l'avis existe déjà pour cet utilisateur et cet article
        $existingAvis = Avis::where('user_id', $request->user_id)
            ->where('article_id', $request->article_id)
            ->first();

        if ($existingAvis) {
            return response()->json(['error' => 'Vous avez déjà laissé un avis pour cet article.'], 409);
        }

        // Création de l'avis
        $avis = Avis::create([
            'user_id' => $request->user_id,
            'article_id' => $request->article_id,
            'contenu' => $request->contenu,
            'note' => $request->note,
        ]);

        // Retourner une réponse JSON avec l'avis créé
        return response()->json($avis, 201);
    }

    // Mettre à jour un avis
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'contenu' => 'required|string',
            'note' => 'required|integer|between:1,5',
        ]);

        // Trouver l'avis par son ID
        $avis = Avis::findOrFail($id);

        // Mettre à jour l'avis avec les nouvelles données
        $avis->update([
            'contenu' => $request->contenu,
            'note' => $request->note,
        ]);

        return response()->json($avis);
    }

    public function repondre(Request $request, $id)
    {
        $request->validate([
            'reponse' => 'required|string',
        ]);

        $avis = Avis::findOrFail($id);
        $avis->reponse = $request->reponse;
        $avis->save();

        return response()->json(['message' => 'Réponse enregistrée avec succès.', 'avis' => $avis]);
    }

    // Supprimer un avis
    public function destroy($id)
    {
        // Trouver l'avis par son ID
        $avis = Avis::findOrFail($id);

        // Supprimer l'avis
        $avis->delete();

        // Retourner un message de succès
        return response()->json(['message' => 'Avis supprimé avec succès']);
    }
}

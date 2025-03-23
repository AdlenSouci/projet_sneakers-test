<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Famille;

class FamilleController extends Controller
{
    public function index()
    {
        $familles = Famille::all();
        return response()->json($familles);
    }

    // Ajouter une nouvelle famille
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom_famille' => 'required|string|max:255',
            //'id_parent' => 'integer', // Validation pour id_parent
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Création de l'article
        try {
            $famille = Famille::create($request->all());

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création de la famille. ' . $e->getMessage()], 500);
        }

        return response()->json($famille, 201);
    }

    // Méthode pour mettre à jour un article (si nécessaire)
    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom_famille' => 'required|string|max:255',
            //'id_parent' => 'integer', // Validation pour id_parent
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $famille = Famille::find($id);
        if (!$famille) {
            return response()->json(['error' => 'Famille non trouvée.'], 404);
        }

        // Mise à jour de l'article
        try {
            $famille->update($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de la famille.'], 500);
        }

        return response()->json($famille, 200);
    }

    public function destroy($id)
    {

        // Trouver l'article par son ID

        $famille = Famille::find($id);
        if (!$famille) {
            return response()->json(['error' => 'Famille non trouvée.'], 404);
        }

        // Suppression de l'article
        try {
            $famille->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de la famille.'], 500);
        }

        return response()->json(['message' => 'Famille supprimée avec succès.'], 200);
    }
}

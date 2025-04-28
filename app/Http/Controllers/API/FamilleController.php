<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Famille;
use Illuminate\Database\QueryException;


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
        // // Validation des données
        // $validator = Validator::make($request->all(), [
        //     'nom_famille' => 'required|string|max:255',
        //     //'id_parent' => 'integer', // Validation pour id_parent
        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        // // Création de l'article
        // try {
        //     $famille = Famille::create($request->all());
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Erreur lors de la création de la famille. ' . $e->getMessage()], 500);
        // }

        // return response()->json($famille, 201);


        $request->validate([
            'nom_famille' => 'required|string|max:255', 
            //'id_parent' => 'integer',
        ]);

        // Création et insertion de la marque dans la base de données
        $familles = Famille::create([
            'nom_famille' => $request->nom_famille, 
        ]);

        // Vérification si l'insertion a réussi
        if ($familles) {
            return response()->json($familles, 201); // Retourne la marque créée avec un code 201 (créé)
        } else {
            return response()->json(['message' => 'Erreur lors de l\'insertion'], 500);
        }
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
        // 1. Trouver la famille par ID
        $famille = Famille::find($id);

        // 2. Vérifier si elle existe -> Correct
        
        if (!$famille) {
            return response()->json(['error' => 'Famille non trouvée.'], 404);
        }
        

        // 3. Tentative de suppression dans un try-catch -> Correct
    try {
        $famille->delete();
        return response()->json(['message' => 'Famille supprimée avec succès.']);
    } catch (QueryException $e) {
        // Vérifie s’il s’agit d’une violation de contrainte de clé étrangère
        if ($e->getCode() === '23000') {
            return response()->json([
                'error' => "Impossible de supprimer cette famille car elle est liée à d'autres enregistrements."
            ], 409); // 409 = Conflict
        }

        // Autres erreurs de requête SQL
        return response()->json([
            'error' => 'Erreur de base de données : ' . $e->getMessage()
        ], 500);
    } catch (\Exception $e) {
        // Erreurs génériques
        return response()->json([
            'error' => 'Erreur lors de la suppression de la famille. ' . $e->getMessage()
        ], 500);
    }


        // 4. Retourner un message de succès -> Correct
        return response()->json(['message' => 'Famille supprimée avec succès.'], 200);
    }
}

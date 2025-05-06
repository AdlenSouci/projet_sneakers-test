<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Couleur;
use Carbon\Carbon;
use illuminate\Support\Facades\Validator;

class CouleurController extends Controller
{
    // Récupérer toutes les couleurs
    public function index()
    {
        $couleurs = Couleur::all();
        return response()->json($couleurs);
    }
    public function store(Request $request)
{
    // Validation des données
    $validator = Validator::make($request->all(), [
        'nom_couleur' => 'required|string|max:255|unique:couleurs,nom_couleur',
    ]);

    if ($validator->fails()) {
        // Vérifier si l'erreur est due à l'unicité du nom de la couleur
        if ($validator->errors()->has('nom_couleur')) {
            return response()->json(['error' => 'Cette couleur existe déjà.'], 409);
        }

        return response()->json($validator->errors(), 400);
    }

    // Création de la couleur
    $couleur = Couleur::create([
        'nom_couleur' => $request->nom_couleur,
    ]);

    // Retourner une réponse JSON avec la couleur créée
    return response()->json($couleur, 201);
}


    public function update(Request $request, $id)
    {

        $request->validate([
            'nom_couleur' => 'required|string|max:255',
        ]);

        // Trouver la couleur par son ID
        $couleur = Couleur::findOrFail($id);


        $couleur->update([
            'nom_couleur' => $request->nom_couleur,
        ]);


        return response()->json($couleur);
    }

    // Supprimer une couleur
    public function destroy($id)
    {
        // Trouver la couleur par son ID
        $couleur = Couleur::findOrFail($id);

        // Supprimer la couleur
        $couleur->delete();

        // Retourner un message de succès
        return response()->json(['message' => 'Couleur supprimée avec succès']);
    }
}

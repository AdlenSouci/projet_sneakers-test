<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Couleur;
use Carbon\Carbon;

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
        $request->validate([
            'nom_couleur' => 'required|string|max:255',
        ]);

        // Vérifier si la couleur existe déjà
        $existingCouleur = Couleur::where('nom_couleur', $request->nom_couleur)->first();
        if ($existingCouleur) {
            return response()->json(['error' => 'Cette couleur existe déjà.'], 409);
        }

        // Création de la couleur
        $couleur = Couleur::create([
            'nom_couleur' => $request->nom_couleur,
        ]);

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

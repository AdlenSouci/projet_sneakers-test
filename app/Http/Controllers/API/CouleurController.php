<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Couleur; 


class CouleurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    } 
    public function index()
    {
        $couleurs = Couleur::all();
        return response()->json($couleurs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_couleur' => 'required|string|max:255', // nom_couleur pour le modèle Couleur
        ]);

        $existingCouleur = Couleur::where('nom_couleur', $request->nom_couleur)->first();
        if ($existingCouleur) {
            return response()->json(['error' => 'Cette couleur existe déjà.'], 409);
        }

        $couleur = Couleur::create([
            'nom_couleur' => $request->nom_couleur,
        ]);

        if ($couleur) {
            return response()->json($couleur, 201);
        } else {
            return response()->json(['message' => 'Erreur lors de l\'insertion'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_couleur' => 'required|string|max:255',
        ]);

        $couleur = Couleur::findOrFail($id);

        $couleur->update([
            'nom_couleur' => $request->nom_couleur,
        ]);

        return response()->json($couleur); // Retourne 200 OK par défaut
    }

    public function destroy($id)
    {
        $couleur = Couleur::findOrFail($id);

        $couleur->delete();

        return response()->json(['message' => 'Couleur supprimée avec succès']);
    }
}
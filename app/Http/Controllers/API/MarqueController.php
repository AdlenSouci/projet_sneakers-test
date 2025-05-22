<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marque;

class MarqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    } 
    // Récupérer toutes les marques depuis la base de données
    public function index()
    {
        $marques = Marque::all(); // Récupère toutes les marques
        return response()->json($marques); // Renvoie les données sous forme de JSON
    }

    // Ajouter une nouvelle marque
    public function store(Request $request)
    {
        // Validation des données envoyées par l'utilisateur
        $request->validate([
            'nom_marque' => 'required|string|max:255',
        ]);

        $existingMarque = Marque::where('nom_marque', $request->nom_marque)->first();
        if ($existingMarque) {
            return response()->json(['error' => 'Cette marque existe déjà.'], 409);
        }

        // Création et insertion de la marque dans la base de données
        $marque = Marque::create([
            'nom_marque' => $request->nom_marque,
        ]);

        // Vérification si l'insertion a réussi
        if ($marque) {
            return response()->json($marque, 201); // Retourne la marque créée avec un code 201 (créé)
        } else {
            return response()->json(['message' => 'Erreur lors de l\'insertion'], 500);
        }
    }

    // Mettre à jour une marque existante
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom_marque' => 'required|string|max:255',
        ]);

        // Trouver la marque par son ID
        $marque = Marque::findOrFail($id);

        // Mise à jour des informations de la marque
        $marque->update([
            'nom_marque' => $request->nom_marque,
        ]);

        // Retourner la marque mise à jour
        return response()->json($marque);
    }

    // Supprimer une marque
    public function destroy($id)
    {
        // Trouver la marque par son ID
        $marque = Marque::findOrFail($id);

        // Supprimer la marque de la base de données
        $marque->delete();

        // Retourner un message de confirmation
        return response()->json(['message' => 'Marque supprimée avec succès']);
    }
}

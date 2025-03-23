<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marque;
use Carbon\Carbon;
class MarqueController extends Controller
{
    // Récupérer toutes les marques
    public function index()
    {
        $marques = Marque::all();
        return response()->json($marques);
    }
    public function store(Request $request)
    {

        $request->validate([
            'nom_marque' => 'required|string|max:255',
        ]);

        // Création de la marque
        $marque = Marque::create([
            'nom_marque' => $request->nom_marque,
        ]);


        return response()->json($marque, 201);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'nom_marque' => 'required|string|max:255',
        ]);

        // Trouver la marque par son ID
        $marque = Marque::findOrFail($id);


        $marque->update([
            'nom_marque' => $request->nom_marque,
        ]);


        return response()->json($marque);
    }

    // Supprimer une marque
    public function destroy($id)
    {
        // Trouver la marque par son ID
        $marque = Marque::findOrFail($id);

        // Supprimer la marque
        $marque->delete();

        // Retourner un message de succès
        return response()->json(['message' => 'Marque supprimée avec succès']);
    }
}

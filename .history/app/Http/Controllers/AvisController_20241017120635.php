<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avis;
use App\Models\CommandeDetail;

class AvisController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'contenu' => 'required|string',
            'note' => 'required|integer|between:1,5',
            'article_id' => 'required|exists:articles,id', // Assurez-vous que l'article existe
        ]);

        // Ajout de l'avis à la base de données
        $avis = Avis::create([
            'user_id' => auth()->id(), // Récupère l'ID de l'utilisateur authentifié
            'article_id' => $validatedData['article_id'],
            'contenu' => $validatedData['contenu'],
            'note' => $validatedData['note'],
        ]);

        // Redirige avec un message de succès
        return redirect()->back()->with('success', 'Votre avis a été ajouté avec succès.');
    }
}

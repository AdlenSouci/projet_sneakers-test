<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avis;
use App\Models\CommandeDetail;

class AvisController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données d'entrée
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'contenu' => 'required|string|max:1000',
            'note' => 'required|integer|between:1,5',
        ]);

        // Récupérer l'utilisateur authentifié
        $userId = auth()->id();

        // Vérifier si l'utilisateur a déjà commandé cet article
        $avis = new Avis();
        $hasOrdered = $avis->aDejaCommande($request->article_id);

        if (!$hasOrdered) {
            return redirect()->back()->withErrors(['error' => 'Vous devez avoir commandé cet article pour laisser un avis.']);
        }

        // Si l'utilisateur a déjà commandé l'article, créez l'avis
        Avis::create([
            'user_id' => $userId,
            'article_id' => $request->article_id,
            'contenu' => $request->contenu,
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Votre avis a été ajouté.');
    }
}

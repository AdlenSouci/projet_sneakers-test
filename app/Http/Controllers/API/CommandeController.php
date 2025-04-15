<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommandeDetail;
use App\Models\CommandeEntete;
use App\Models\Article;

class CommandeController extends Controller
{
    public function index()
    {
        // Récupérer les entêtes de commandes (associées aux détails)
        $commandes = CommandeEntete::with('details')->get();
        return response()->json($commandes);
    }
    //crer la fonction store en utilant entete mais aussi detail 

    public function store(Request $request)
{
    // Validation des données
    $validated = $request->validate([
        'id_user' => 'required|integer',
        'id_num_commande' => 'required|integer',
        'total_ht' => 'required|numeric',
        'total_ttc' => 'required|numeric',
        'total_tva' => 'required|numeric',
        'total_remise' => 'required|numeric',
        'details' => 'required|array',
        'details.*.id_article' => 'required|integer',
        'details.*.taille' => 'required|string',
        'details.*.quantite' => 'required|integer',
        'details.*.prix_ht' => 'required|numeric',
        'details.*.prix_ttc' => 'required|numeric',
        'details.*.montant_tva' => 'required|numeric',
        'details.*.remise' => 'required|numeric',
    ]);

    // Créer une nouvelle entête de commande
    $commande = CommandeEntete::create([
        'id_user' => $validated['id_user'],
        'id_num_commande' => $validated['id_num_commande'],
        'total_ht' => $validated['total_ht'],
        'total_ttc' => $validated['total_ttc'],
        'total_tva' => $validated['total_tva'],
        'total_remise' => $validated['total_remise'],
        'date' => now(),  // Ajouter la date actuelle
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Créer des détails de commande associés
    foreach ($validated['details'] as $detail) {
        // Récupération de l'article à partir de son ID
        $article = Article::find($detail['id_article']);

        // Vérification que l'article existe
        if (!$article) {
            return response()->json(['error' => 'Article non trouvé.'], 404);
        }

        // Créer un détail de commande avec les informations de l'article
        CommandeDetail::create([
            'id_commande' => $commande->id,
            'id_article' => $article->id,
            'taille' => $detail['taille'],
            'quantite' => $detail['quantite'],
            'prix_ht' => $article->prix_achat,   // Utilisation du prix d'achat
            'prix_ttc' => $article->prix_public,  // Utilisation du prix public
            'montant_tva' => $detail['montant_tva'], // Montant de la TVA
            'remise' => $detail['remise'],        // Remise de l'article
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return response()->json($commande, 201);
}

}

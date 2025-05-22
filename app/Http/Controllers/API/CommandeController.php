<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\CommandeDetail;
use App\Models\CommandeEntete;
use App\Models\Article;
use App\Models\User;
class CommandeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    } 
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
            'name' => 'required|string',
         
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
            'name' => $validated['name'],
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

    public function destroy($id)
    {
        Log::info("Requête DELETE reçue pour commande ID: {$id}");

        // 1. Trouver l'en-tête de commande par sa clé primaire 'id'
        $commande = CommandeEntete::find($id);

        // 2. Vérifier si la commande existe
        if (!$commande) {
            Log::warning("Commande ID {$id} non trouvée pour suppression.");
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }

        // 3. Tentative de suppression (détails d'abord)
        try {
            // *** LA CORRECTION EST ICI ***
            // Utilise la relation définie dans le modèle CommandeEntete.
            // Notez la majuscule 'D' si votre méthode s'appelle bien 'Details'
            Log::info("Tentative de suppression des détails pour commande ID: {$id}");
            $commande->Details()->delete(); // Supprime tous les enregistrements liés dans commandes_details

            // Maintenant que les détails sont supprimés, on peut supprimer l'en-tête
            Log::info("Tentative de suppression de l'en-tête pour commande ID: {$id}");
            $commande->delete(); // Supprime l'enregistrement dans commandes_entetes

            Log::info("Commande ID {$id} et ses détails supprimés avec succès.");
            return response()->json(['message' => 'Commande et détails supprimés avec succès']);
        } catch (\Illuminate\Database\QueryException $e) {
            // Gérer les erreurs spécifiques à la base de données
            Log::error("Erreur BDD lors suppression commande ID {$id}: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'message' => 'Erreur de base de données lors de la suppression.',
                'error_details' => $e->getMessage() // Fournir des détails peut aider
            ], 500);
        } catch (\Exception $e) {
            // Gérer toute autre erreur inattendue
            Log::error("Erreur inattendue lors suppression commande ID {$id}: " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Une erreur serveur inattendue est survenue.'], 500);
        }
    }
}

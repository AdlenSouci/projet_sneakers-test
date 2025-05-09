<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommandeEntete;
use App\Models\CommandeDetail;
use App\Http\Controllers\toArray;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cart;

use Illuminate\Support\Facades\Log;


class BasketController extends Controller
{
    private function calculerTotalArticles($cartItems)
    {
        return array_sum(array_column($cartItems, 'quantity'));
    }
    private function calculerPrixTotal($cartItems)
    {
        $totalPrice = 0;


        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return $totalPrice;
    }

    // ne pas additionner les paires du meme articles si les pointures sont différentes

    public function ajouter_au_panier(Request $request)
    {
        // Validation des données
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'pointure' => 'required|string',
            'quantite' => 'required|integer|min:1|max:10',

        ]);

        $article = Article::findOrFail($request->article_id);
        $pointure = $request->pointure;
        $quantite = $request->quantite;
        $stock = $article->tailles()->where('taille', $pointure)->first()->stock;

        $cartItems = Session::get('cart', []);
        $existingItemKey = array_search($article->id, array_column($cartItems, 'id'));

        if ($quantite > $stock) {
            return response()->json(['message' => "Désolé, il ne reste que " . $stock . " paires en stock"]);
        } else {
            if ($existingItemKey !== false) {

                if ($cartItems[$existingItemKey]['taille'] === $pointure) {

                    $cartItems[$existingItemKey]['quantity'] += $quantite;
                } else {
                    // Si la taille est différente, ajoutez un nouvel article
                    $cartItems[] = [
                        'id' => $article->id,
                        'name' => $article->modele,
                        'image' => $article->img,
                        'price' => $article->prix_public,
                        'quantity' => $quantite,
                        'taille' => $pointure,
                    ];
                }
            } else {
                // Sinon, ajoutez un nouvel article
                $cartItems[] = [
                    'id' => $article->id,
                    'name' => $article->modele,
                    'image' => $article->img,
                    'price' => $article->prix_public,
                    'quantity' => $quantite,
                    'taille' => $pointure,
                    'tailles' => $article->tailles,
                ];
            }

            Session::put('cart', $cartItems);

            // Mettre à jour le nombre total d'articles dans la session
            $totalItems = array_sum(array_column($cartItems, 'quantity'));
            Session::put('totalItems', $totalItems);

            $totalPrice = $this->calculerPrixTotal($cartItems);
            return response()->json([
                'message' => 'Article ajouté au panier avec succès',
                'totalPrice' => $totalPrice,
                'nbitems' => $totalItems,
            ]);
        }
    }

    public function index()
    {
        // Récupération des articles du panier
        $cartItems = session()->get('cart', []);

        // Calculer le prix total
        $totalPrice = $this->calculerPrixTotal($cartItems);

        // Calculer le nombre total d'articles
        $totalItems = $this->calculerTotalArticles($cartItems);

        // Récupérer les articles avec les tailles et le stock
        $articles = [];
        foreach ($cartItems as $item) {
            $article = Article::with('tailles')->where('id', $item['id'])->first();
            if ($article) {
                $articles[] = $article;
            }
        }

        // Renvoyer la vue avec les articles du panier et le prix total
        return view('basket', compact('cartItems', 'articles', 'totalPrice', 'totalItems'));
    }



    public function changerQuantiterPanier(Request $request)
    {
        // Valider les données reçues
        $validatedData = $request->validate([
            'article_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $articleId = $validatedData['article_id'];
        $quantity = $validatedData['quantity'];

        // Récupérer le panier de l'utilisateur
        $cart = session()->get('cart', []);

        // Vérifier si l'article existe dans le panier
        $existingItemKey = array_search($articleId, array_column($cart, 'id'));

        if ($existingItemKey !== false) {
            // Mettre à jour la quantité
            $cart[$existingItemKey]['quantity'] = $quantity;

            // Réenregistrer le panier dans la session
            session()->put('cart', $cart);

            // Calculer le nombre total d'articles dans le panier
            $totalItems = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'message' => 'Quantité mise à jour avec succès.',
                'totalItems' => $totalItems,
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => "L'article n'existe pas dans le panier.",
        ]);
    }










    public function viderPanier()
    {
        Session::forget('cart');
        Session::put('totalItems', 0); // Réinitialiser le compteur d'articles
        return response()->json(['message' => 'Le panier a été vidé avec succès']);
    }
    public function viderArticlePanier(Request $request)
    {

        $request->validate([
            'article_id' => 'required|exists:articles,id',
        ]);


        $article = Article::findOrFail($request->article_id);


        $cartItems = Session::get('cart', []);


        $itemIndex = array_search($article->id, array_column($cartItems, 'id'));

        if ($itemIndex !== false) {

            array_splice($cartItems, $itemIndex, 1);


            Session::put('cart', $cartItems);


            $totalItems = array_sum(array_column($cartItems, 'quantity'));
            Session::put('totalItems', $totalItems);

            $totalPrice = $this->calculerPrixTotal($cartItems);


            return response()->json([
                'message' => 'Article supprimé avec succès',
                'totalPrice' => $totalPrice,
                'cart' => $cartItems,
            ]);
        }


        return response()->json(['error' => 'Article non trouvé dans le panier']);
    }



    public function passerCommande(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
            'ville' => 'required|string|max:255',
        ]);
        $userId = Auth::id();
        $user = Auth::user();

        // Vérifier si l'utilisateur est bien récupéré
        if (!$user) {
            Log::error("Tentative de commande par un utilisateur non authentifié ou introuvable.");
            return response()->json(['error' => true, 'message' => 'Utilisateur non trouvé.'], 401);
        }

        $email = $user->email;
        $adresseLivraison = $request->adresse_livraison;
        // $userName = $request->name;
        $userName = $user->name;

        // Récupérer l'adresse de livraison enregistrée
        $adresseLivraisonEnregistree = $user->adresse_livraison;

        // Vérifier si l'adresse saisie correspond à l'adresse enregistrée
        // NOTE : Cette logique empêche l'utilisation d'une adresse différente de celle enregistrée.
        // Si tu veux permettre une adresse de livraison différente, tu devrais commenter ou supprimer ce bloc.
        if ($adresseLivraison !== $adresseLivraisonEnregistree) {
            return response()->json(['error' => true, 'message' => 'L\'adresse de livraison saisie ne correspond pas à l\'adresse enregistrée.']);
        }

        $numCommande = mt_rand(100000, 999999); // Attention: potentiel de collision si beaucoup de commandes

        // Variables pour le total
        $total_ht = 0;
        $total_ttc = 0;
        $total_tva = 0;

        // Récupérer le panier avant le try/catch pour vérifier s'il est vide
        $cartItems = Session::get('cart', []);
        if (empty($cartItems)) {
            return response()->json(['error' => true, 'message' => 'Votre panier est vide.'], 400);
        }

        try {
            // Création de l'objet CommandeEntete
            $commandeEntete = new CommandeEntete;
            $commandeEntete->id_num_commande = $numCommande;
            $commandeEntete->date = now();
            $commandeEntete->id_user = $userId; // ID de l'utilisateur

            // --- AJOUT DES INFORMATIONS CLIENT ICI ---
            $commandeEntete->telephone = $user->telephone;       // Récupéré depuis l'objet User authentifié
            $commandeEntete->ville = $user->ville;               // Récupéré depuis l'objet User authentifié
            $commandeEntete->code_postal = $user->code_postal;     // Récupéré depuis l'objet User authentifié
            $commandeEntete->adresse_livraison = $adresseLivraison; // Utilise l'adresse validée provenant du formulaire ($request)
            // --- FIN DE L'AJOUT ---

            // Initialisation des totaux (sera mis à jour plus tard)
            $commandeEntete->total_ht = 0;
            $commandeEntete->total_ttc = 0;
            $commandeEntete->total_tva = 0;
            $commandeEntete->total_remise = 0; // Initialisation

            // Sauvegarde initiale de l'entête (avec les infos client ajoutées)
            $commandeEntete->save();

            $lastItemNameForEmail = ''; // Variable pour stocker le nom du dernier article pour l'email (attention: bug potentiel dans l'email original)

            foreach ($cartItems as $item) {
                // Assurer que les données minimales existent dans l'item du panier
                if (!isset($item['id'], $item['price'], $item['quantity'], $item['taille'])) {
                    Log::warning('Item invalide dans le panier lors de la commande : ' . json_encode($item));
                    continue; // Saute cet article invalide
                }

                // Utilisation de tes calculs HT/TVA originaux
                $prixLigneTTC = $item['price'] * $item['quantity'];
                $prixLigneHT = $prixLigneTTC * 0.8; // Ton calcul original
                $montantLigneTVA = $prixLigneTTC * 0.2; // Ton calcul original

                $commandeEntete->Details()->create([
                    'id_commande' => $commandeEntete->id,
                    'id_article' => $item['id'],
                    'taille' => $item['taille'],
                    'quantite' => $item['quantity'],
                    'prix_ttc' => $prixLigneTTC,
                    'prix_ht' => $prixLigneHT,
                    'montant_tva' => $montantLigneTVA,
                    'remise' => 0, // Gérer la remise si nécessaire
                ]);

                // Mise à jour des totaux globaux
                $total_ht += $prixLigneHT;
                $total_ttc += $prixLigneTTC;
                $total_tva += $montantLigneTVA;

                // Mise à jour du stock
                $article = Article::find($item['id']);
                if ($article) {
                    // Trouver la taille spécifique et décrémenter le stock
                    $tailleStock = $article->tailles()->where('taille', $item['taille'])->first();
                    if ($tailleStock) {
                        $stockActuel = $tailleStock->stock;
                        // Décrémente le stock, sans aller en dessous de 0
                        $quantiteADeduire = min($stockActuel, $item['quantity']);
                        if ($quantiteADeduire > 0) {
                            $tailleStock->decrement('stock', $quantiteADeduire);
                        } else {
                            Log::warning("Stock déjà à 0 ou négatif pour article ID {$item['id']} taille {$item['taille']} avant décrémentation.");
                        }
                    } else {
                        Log::error("Impossible de trouver la taille '{$item['taille']}' pour l'article ID {$item['id']} lors de la mise à jour du stock.");
                        // Considérer de jeter une exception ou d'annuler ici si le stock est critique
                    }
                } else {
                    Log::error("Article ID {$item['id']} non trouvé lors de la mise à jour du stock.");
                    // Considérer de jeter une exception ou d'annuler ici
                }

                // Stocke le nom du dernier article pour l'email (conserve le comportement original)
                if (isset($item['name'])) {
                    $lastItemNameForEmail = $item['name'];
                }
            }

            // Mise à jour finale des totaux dans l'entête
            $commandeEntete->total_ht = $total_ht;
            $commandeEntete->total_ttc = $total_ttc;
            $commandeEntete->total_tva = $total_tva;
            // $commandeEntete->total_remise = $total_remise; // Si tu calcules une remise globale
            $commandeEntete->save(); // Sauvegarde les totaux mis à jour

            // Vider le panier après succès
            Session::forget('cart');

            // --- Envoi des emails (code original) ---
            try {
                // Envoyer un mail à l'administrateur
                $subjectAdmin = 'Nouvelle Commande Passée sur le Site';
                // Ajout des détails dans le message admin pour plus de clarté
                $messageAdmin = "Une nouvelle commande (#{$commandeEntete->id_num_commande}) a été passée par le client : ($userName) - Email: {$email}\n";
                $messageAdmin .= "Date de la commande: " . $commandeEntete->date->format('d/m/Y H:i:s') . "\n";
                $messageAdmin .= "Adresse de livraison: {$commandeEntete->adresse_livraison}, {$commandeEntete->code_postal} {$commandeEntete->ville}\n";
                $messageAdmin .= "Téléphone: {$commandeEntete->telephone}\n";
                $messageAdmin .= "Total TTC de la commande: " . number_format($total_ttc, 2, ',', ' ') . " €\n\n";
                // Note: Le détail '$item['name']' ici ne montrera que le nom du *dernier* article de la boucle.
                // Pour une liste complète, il faudrait construire la chaîne dans la boucle.
                $messageAdmin .= "Détails (dernier article): " . $lastItemNameForEmail;

                Mail::raw($messageAdmin, function ($message) use ($subjectAdmin) {
                    $message->to('adlenssouci03@gmail.com') // Email Admin
                        ->subject($subjectAdmin);
                });


                // Email de confirmation de commande pour le client
                $subjectClient = 'Confirmation de commande N°' . $commandeEntete->id_num_commande;

                $data = [
                    'userName' => $userName,
                    'commandeId' => $commandeEntete->id_num_commande,
                    'date' => $commandeEntete->date->format('d/m/Y H:i:s'),
                    'adresseLivraison' => $adresseLivraison,
                    'codePostal' => $user->code_postal,
                    'ville' => $user->ville,
                    'articles' => $cartItems, // Détails des articles
                    'totalTTC' => $total_ttc,
                ];

                // Envoyer l'email avec le template
                Mail::send('emails.confirmation_commande', $data, function ($mail) use ($email, $subjectClient) {
                    $mail->to($email) // Email Client
                        ->subject($subjectClient);
                });
            } catch (\Exception $mailError) {
                Log::error("Erreur lors de l'envoi des emails pour la commande {$commandeEntete->id_num_commande}: " . $mailError->getMessage());
                // Ne pas bloquer la réponse utilisateur si l'email échoue
            }
            // --- Fin Envoi Emails ---


            // Retourne le message de succès avec l'ID de la commande
            return response()->json(['success' => true, 'message' => 'Commande passée avec succès !', 'commande_id' => $commandeEntete->id]);
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            Log::error("Erreur lors de la création de la commande : " . $e->getMessage() . " Stack: " . $e->getTraceAsString());
            // Retourne un message d'erreur générique à l'utilisateur
            return response()->json(['error' => true, 'message' => 'Une erreur technique est survenue lors de la création de votre commande. Détail : ' . $e->getMessage()], 500);
        }
    }
}

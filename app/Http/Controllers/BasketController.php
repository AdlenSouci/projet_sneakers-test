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
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'pointure' => 'required|string',
            'quantite' => 'required|integer|min:1|max:10',
        ]);

        $article = Article::findOrFail($request->article_id);
        $pointure = $request->pointure;
        $quantiteAjoutee = $request->quantite;

        $tailleArticle = $article->tailles()->where('taille', $pointure)->first();

        if (!$tailleArticle || $tailleArticle->stock < 0) {
            return response()->json(['message' => "Pointure non disponible pour cet article."], 400);
        }

        $stockDisponibleTotal = $tailleArticle->stock;


        $cartItems = Session::get('cart', []);

        $existingItemKey = null;
        $quantiteDejaDansPanier = 0;

        foreach ($cartItems as $key => $item) {
            if (isset($item['id']) && $item['id'] === $article->id && isset($item['taille']) && $item['taille'] === $pointure) {
                $existingItemKey = $key;
                $quantiteDejaDansPanier = $item['quantity'];
                break;
            }
        }

        $nouvelleQuantiteTotaleDansPanier = $quantiteDejaDansPanier + $quantiteAjoutee;

        if ($nouvelleQuantiteTotaleDansPanier > $stockDisponibleTotal) {
            return response()->json(['message' => "Désolé, il ne reste que " . $stockDisponibleTotal . " paires en stock pour la taille " . $pointure . "."], 400);
        } else {
            if ($existingItemKey !== null) {
                $cartItems[$existingItemKey]['quantity'] = $nouvelleQuantiteTotaleDansPanier;
            } else {
                $cartItems[] = [
                    'id' => $article->id,
                    'name' => $article->modele,
                    'image' => $article->img,
                    'price' => $article->prix_public,
                    'quantity' => $quantiteAjoutee,
                    'taille' => $pointure,
                ];
            }

            Session::put('cart', $cartItems);

            $totalItems = array_sum(array_column($cartItems, 'quantity'));
            Session::put('totalItems', $totalItems);

            $totalPrice = $this->calculerPrixTotal($cartItems);

            return response()->json([
                'message' => 'Article ajouté au panier avec succès',
                'totalPrice' => $totalPrice,
                'nbitems' => $totalItems,
            ], 200);
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

        if (!$user) {
            Log::error("Tentative de commande par un utilisateur non authentifié ou introuvable.");
            return response()->json(['error' => true, 'message' => 'Utilisateur non trouvé.'], 401);
        }

        $email = $user->email;
        $adresseLivraison = $request->adresse_livraison;
        $userName = $user->name;

        $adresseLivraisonEnregistree = $user->adresse_livraison;

        if ($adresseLivraison !== $adresseLivraisonEnregistree) {
            return response()->json(['error' => true, 'message' => 'L\'adresse de livraison saisie ne correspond pas à l\'adresse enregistrée.']);
        }

        $numCommande = mt_rand(100000, 999999);

        $total_ht = 0;
        $total_ttc = 0;
        $total_tva = 0;

        $cartItems = Session::get('cart', []);
        if (empty($cartItems)) {
            return response()->json(['error' => true, 'message' => 'Votre panier est vide.'], 400);
        }

        try {
            $commandeEntete = new CommandeEntete;
            $commandeEntete->id_num_commande = $numCommande;
            $commandeEntete->date = now();
            $commandeEntete->id_user = $userId;
            $commandeEntete->name = $userName;
            $commandeEntete->telephone = $user->telephone;
            $commandeEntete->ville = $user->ville;
            $commandeEntete->code_postal = $user->code_postal;
            $commandeEntete->adresse_livraison = $adresseLivraison;

            $commandeEntete->total_ht = 0;
            $commandeEntete->total_ttc = 0;
            $commandeEntete->total_tva = 0;
            $commandeEntete->total_remise = 0;

            $commandeEntete->save();

            $lastItemNameForEmail = '';

            foreach ($cartItems as $item) {
                if (!isset($item['id'], $item['price'], $item['quantity'], $item['taille'])) {
                    Log::warning('Item invalide dans le panier : ' . json_encode($item));
                    continue;
                }

                $prixLigneTTC = $item['price'] * $item['quantity'];
                $prixLigneHT = $prixLigneTTC * 0.8;
                $montantLigneTVA = $prixLigneTTC * 0.2;

                $commandeEntete->Details()->create([
                    'id_commande' => $commandeEntete->id,
                    'id_article' => $item['id'],
                    'taille' => $item['taille'],
                    'quantite' => $item['quantity'],
                    'prix_ttc' => $prixLigneTTC,
                    'prix_ht' => $prixLigneHT,
                    'montant_tva' => $montantLigneTVA,
                    'remise' => 0,
                ]);

                $total_ht += $prixLigneHT;
                $total_ttc += $prixLigneTTC;
                $total_tva += $montantLigneTVA;

                $article = Article::find($item['id']);
                if ($article) {
                    $tailleStock = $article->tailles()->where('taille', $item['taille'])->first();
                    if ($tailleStock) {
                        $stockActuel = $tailleStock->stock;
                        $quantiteADeduire = min($stockActuel, $item['quantity']);
                        if ($quantiteADeduire > 0) {
                            $tailleStock->decrement('stock', $quantiteADeduire);
                        } else {
                            Log::warning("Stock insuffisant pour article ID {$item['id']} taille {$item['taille']}.");
                        }
                    } else {
                        Log::error("Taille '{$item['taille']}' introuvable pour l'article ID {$item['id']}.");
                    }
                } else {
                    Log::error("Article ID {$item['id']} non trouvé.");
                }

                if (isset($item['name'])) {
                    $lastItemNameForEmail = $item['name'];
                }
            }

            $commandeEntete->total_ht = $total_ht;
            $commandeEntete->total_ttc = $total_ttc;
            $commandeEntete->total_tva = $total_tva;
            $commandeEntete->save();

            Session::forget('cart');

            // --- Envoi des emails ---
            try {
                $subjectAdmin = 'Nouvelle Commande Passée sur le Site';
                $messageAdmin = "Une nouvelle commande (#{$commandeEntete->id_num_commande}) a été passée par le client : ($userName) - Email: {$email}\n";
                $messageAdmin .= "Date de la commande: " . $commandeEntete->date->format('d/m/Y H:i:s') . "\n";
                $messageAdmin .= "Adresse de livraison: {$commandeEntete->adresse_livraison}, {$commandeEntete->code_postal} {$commandeEntete->ville}\n";
                $messageAdmin .= "Téléphone: {$commandeEntete->telephone}\n";
                $messageAdmin .= "Total TTC de la commande: " . number_format($commandeEntete->total_ttc, 2, ',', ' ') . " €\n";

                Mail::raw($messageAdmin, function ($message) use ($subjectAdmin) {
                    $message->to('adlenssouci03@gmail.com')
                        ->subject($subjectAdmin);
                });

                $subjectClient = 'Confirmation de commande N°' . $commandeEntete->id_num_commande;
                $data = [
                    'userName' => $userName,
                    'commandeId' => $commandeEntete->id_num_commande,
                    'date' => $commandeEntete->date->format('d/m/Y H:i:s'),
                    'adresseLivraison' => $commandeEntete->adresse_livraison,
                    'codePostal' => $commandeEntete->code_postal,
                    'ville' => $commandeEntete->ville,
                    'articles' => $cartItems,
                    'totalTTC' => $commandeEntete->total_ttc,
                ];

                Mail::send('emails.confirmation_commande', $data, function ($mail) use ($email, $subjectClient) {
                    $mail->to($email)
                        ->subject($subjectClient);
                });
            } catch (\Exception $mailError) {
                Log::error("Erreur lors de l'envoi des emails pour la commande {$commandeEntete->id_num_commande}: " . $mailError->getMessage());
            }
            // --- Fin envoi emails ---

            return response()->json([
                'success' => true,
                'message' => 'Commande passée avec succès !',
                'commande_id' => $commandeEntete->id
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la création de la commande : " . $e->getMessage() . " Stack: " . $e->getTraceAsString());
            return response()->json([
                'error' => true,
                'message' => 'Une erreur technique est survenue lors de la création de votre commande. Détail : ' . $e->getMessage()
            ], 500);
        }
    }
}

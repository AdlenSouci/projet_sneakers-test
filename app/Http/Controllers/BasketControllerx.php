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
                // Si l'article existe déjà, mettez à jour la quantité
                $cartItems[$existingItemKey]['quantity'] += $quantite;
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

        $userId = Auth::id();
        $user = Auth::user();
        $email = $user->email;
        $adresseLivraison = $request->adresse_livraison;
        $userName = $request->name;

        $numCommande = mt_rand(100000, 999999);

        // Variables pour le total
        $total_ht = 0;
        $total_ttc = 0;
        $total_tva = 0;

        try {

            $commandeEntete = new CommandeEntete;
            $commandeEntete->id_num_commande = $numCommande;
            $commandeEntete->date = now();
            $commandeEntete->id_user = $userId;
            $commandeEntete->total_ht = 0;
            $commandeEntete->save();



            $cartItems = Session::get('cart', []);


            foreach ($cartItems as $item) {

                $commandeEntete->Details()->create([
                    'id_commande' => $commandeEntete->id,
                    'id_article' => $item['id'],
                    'taille' => $item['taille'],
                    'quantite' => $item['quantity'],

                    // La boutique est en ttc
                    'prix_ttc' => $item['price'] * $item['quantity'],
                    // On calcule le prix ht
                    'prix_ht' => $item['price'] * $item['quantity'] * .8,
                    // On calcule le montant de la tva
                    'montant_tva' => $item['price'] * $item['quantity'] * .2,
                    'remise' => 0,
                ]);


                $total_ht += $item['price'] * $item['quantity'] * .8;
                $total_ttc += $item['price'] * $item['quantity'];
                $total_tva += $item['price'] * $item['quantity'] * .2;

                $article = Article::find($item['id']);
                $stock = $article->tailles()->where('taille', $item['taille'])->get()->first()->stock;
                $article->tailles()->where('taille', $item['taille'])->decrement('stock', min($stock, $item['quantity']));
            }


            $commandeEntete->total_ht = $total_ht;
            $commandeEntete->total_ttc = $total_ttc;
            $commandeEntete->total_tva = $total_tva;
            $commandeEntete->save();
            //envoyer un mail a l'administrateur adlenssouci03@gmail.com



        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        //$this->viderPanier();
        $subject = 'Nouvelle Commande Passée sur le Site';
        // $message = "Une nouvelle commande a été passée par le client: {$userId}\n";
        $message = "Une nouvelle commande a été passée par le client:($userName)\n";
        $message .= "Date de la commande: {$commandeEntete->date}\n";
        $message .= "Total de la commande: {$total_ttc} €\n\n";
        $message .= "Détails de la commande:\n" . $item['name'];

        Mail::raw($message, function ($message) {
            $message->to('adlenssouci03@gmail.com')
                ->subject('Nouvelle Commande sur votre site');
        });

        //email de confirmation de commande pour le client 
        $message_confirmation = "Merci pour votre commande!";
        $message_confirmation .= "Détails de la commande:\n" . $item['name'];
        $message_confirmation .= "Total de la commande : {$total_ttc} €\n\n";
        Mail::raw($message_confirmation, function ($mail) use ($email) {
            $mail->to($email)
                ->subject('Confirmation de commande');
        });
        // Envoyer un email de confirmation au client

        return response()->json(['message' => 'Commande passée avec succès ' . $commandeEntete->id]);
    }
} 
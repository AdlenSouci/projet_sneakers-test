<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommandeEntete;
use App\Models\CommandeDetail;
use App\Http\Controllers\toArray;
use App\Models\expedition_entete;


class BasketController extends Controller
{

    private function calculerPrixTotal($cartItems)
    {
        $totalPrice = 0;
        

        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return $totalPrice;
    }
    public function changerQuantiter(Request $request)
    {
        // Validation des données
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'quantity' => 'required|integer|min:1',
        ]);


        $article = Article::findOrFail($request->article_id);


        $cartItems = Session::get('cart', []);

        $itemIndex = array_search($article->id, array_column($cartItems, 'id'));

        // Mettre à jour la quantité de l'article dans le panier
        if ($itemIndex !== false) {
            $cartItems[$itemIndex]['quantity'] = $request->quantity;

            // Mettre à jour le panier dans la session
            Session::put('cart', $cartItems);


            $totalPrice = $this->calculerPrixTotal($cartItems);


            return response()->json([
                'message' => 'Quantité mise à jour avec succès',
                'totalPrice' => $totalPrice,
                'cart' => $cartItems,

            ]);
        }

        return response()->json(['error' => 'Article non trouvé dans le panier']);
    }



    public function index()
    {

        $cartItems = Session::get('cart', []);



        $totalPrice = $this->calculerPrixTotal($cartItems);
        //$tailles = Article::find($cartItems->Id)->tailles();

        //return view('basket', ['cartItems' => $cartItems, 'totalPrice' => $totalPrice, 'tailles' => $tailles]);
        return view('basket', ['cartItems' => $cartItems, 'totalPrice' => $totalPrice]);
    }




    public function ajouter_au_panier(Request $request)
    {
        // Validation des données
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'pointure' => 'required|string',
            'quantite' => 'required|integer|min:1,max:10',
        ]);


        $article = Article::findOrFail($request->article_id);
        $pointure = $request->pointure;
        $quantite = $request->quantite;



        $cartItems = Session::get('cart', []);


        $existingItemKey = array_search($article->id, array_column($cartItems, 'id'));

        if ($existingItemKey !== false) {
            return response()->json(['message' => 'Article déjà dans le panier']);
        } elseif ($quantite > $article->tailles()->where('taille', $pointure)->get()->first()->stock) {
            return response()->json(['message' => "Désolé, il ne reste que " . $article->tailles()->where('taille', $pointure)->get()->first()->stock . " paires en stock"]);
        } else {

            $cartItems[] = [
                'id' => $article->id,
                'name' => $article->modele,
                'image' => $article->img,
                'price' => $article->prix_public,
                'quantity' => $quantite,
                'taille' => $pointure,
                'tailles' => $article->tailles,
            ];


            Session::put('cart', $cartItems);

            $totalPrice = $this->calculerPrixTotal($cartItems);

            return response()->json(['message' => 'Article ajouté au panier avec succès', 'totalPrice' => $totalPrice, 'nbitems' => count($cartItems)]);
        }
    }


    public function viderPanier()
    {
        // Supprimez le panier de la session
        Session::forget('cart');

        Session::put('cart', []);


        return response()->json(['message' => 'Le panier a été vidé avec succès']);
    }
    public function viderArticlePanier(Request $request)
    {
        // Valide les données
        $request->validate([
            'article_id' => 'required|exists:articles,id',
        ]);

        // Récupére l'article à partir de la base de données
        $article = Article::findOrFail($request->article_id);


        $cartItems = Session::get('cart', []);

        // Trouver l'index de l'article dans le panier
        $itemIndex = array_search($article->id, array_column($cartItems, 'id'));

        if ($itemIndex !== false) {

            array_splice($cartItems, $itemIndex, 1);

            // Mettre à jour le panier dans la session
            Session::put('cart', $cartItems);


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
        $adresseLivraison = $request->adresse_livraison;


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

                // Calcul du cumul commande
                $total_ht += $item['price'] * $item['quantity'] * .8;
                $total_ttc += $item['price'] * $item['quantity'];
                $total_tva += $item['price'] * $item['quantity'] * .2;

                $article = Article::find($item['id']);
                $stock = $article->tailles()->where('taille', $item['taille'])->get()->first()->stock;
                $article->tailles()->where('taille', $item['taille'])->decrement('stock', min($stock, $item['quantity']));
            }

            // Mise à jour de la commande avec le total ht
            $commandeEntete->total_ht = $total_ht;
            $commandeEntete->total_ttc = $total_ttc;
            $commandeEntete->total_tva = $total_tva;
            $commandeEntete->save();

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        //$this->viderPanier();
        return response()->json(['message' => 'Commande passée avec succès ' . $commandeEntete->id]);
    }

    public function expedition(Request $request)
    {

        $userId = Auth::id();

        $adresseLivraison = $request->input('adresse_livraison');

        $numBonLivraison = mt_rand(100000, 999999);

        try {

            $expeditionEntete = new expedition_entete();
            $expeditionEntete->id_num_bon_livraison = $numBonLivraison;
            $expeditionEntete->date = now();
            $expeditionEntete->id_user = $userId;
            $expeditionEntete->save();

            $cartItems = Session::get('cart', []);

            foreach ($cartItems as $item) {

                $expeditionEntete->details()->create([
                    'id_num_commande' => $item['id_num_commande'],
                    'id_num_bon_livraison' => $numBonLivraison,

                    'id_article' => $item['id_article'],
                    'adresse' => $adresseLivraison,
                    'quantite_livraison' => $item['quantity'],
                    'prix_ht' => $item['price'] * .8,
                    'prix_ttc' => $item['price'],
                    'montant_ht' => $item['price'] * .8 * $item['quantity'],
                    'remise' => 0,
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Expédition effectuée avec succès ' . $expeditionEntete->id]);
    }

}

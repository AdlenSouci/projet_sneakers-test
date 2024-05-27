<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\assertNotNull;

class BasketControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;



    public function test_ajouter_panier(): void
    {
   
        $article = Article::factory()->create();
        
        $this.assertNotNull($article);

        // Session::put('cart', [$article]);
        
      
        // $response = $this->postJson(route('ajouterPanier', $article->id));

        // $response->assertStatus(200);
        // $response->assertJson(['message' => 'L\'article a été ajouté au panier']);
        

        // $this->assertNotEmpty(Session::get('cart'));
        // $this->assertCount(1, Session::get('cart'));
    }

    public function test_supprimer_panier(): void
    {
        // Simulez un article dans le panier
        $article = Article::factory()->create();
        $this.assertNotNull($article);
        
        // // Mettez cet article dans la session
        // Session::put('cart', [$article]);
        
        // // Appelez l'API pour supprimer l'article du panier
        // $response = $this->postJson(route('supprimerPanier', $article->id));
        
        // // Vérifiez la réponse
        // $response->assertStatus(200);
        // $response->assertJson(['message' => 'L\'article a été supprimé du panier']);
        
        // // Vérifiez que la session est vide
        // $this->assertEmpty(Session::get('cart'));
    }

    public function test_vider_panier(): void
    {
        // Simulez des articles dans le panier
        $cartItems = [
            [
                'id' => 1,
                'name' => 'Article 1',
                'price' => 100,
                'quantity' => 2,
                'taille' => '38',
            ],
            [
                'id' => 2,
                'name' => 'Article 2',
                'price' => 200,
                'quantity' => 1,
                'taille' => '40',
            ],
        ];

        // Mettez ces articles dans la session
        Session::put('cart', $cartItems);

        // Appelez l'API pour vider le panier
        $response = $this->postJson(route('viderPanier'));

        // Vérifiez la réponse
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Le panier a été vidé avec succès']);

        // Vérifiez que la session est vide
        $this->assertEmpty(Session::get('cart'));
    }

    public function test_passer_commande(): void
    {
        // Simulez des articles dans le panier
        $cartItems = [
            [
                'id_' => 1,
                'name' => 'Article 1',
                'price' => 100,
                'quantity' => 2,
                'taille' => '38',
                'id_user' => 1
            ],
            [
                'id' => 2,
                'name' => 'Article 2',
                'price' => 200,
                'quantity' => 1,
                'taille' => '40',
                'id_user' => 1
            ],
        ];



        // Mettez ces articles dans la sessiona
        Session::put('cart', $cartItems);

        // Appelez l'API pour passer la commande
        $response = $this->postJson(route('passer-commande'));

        // Vérifiez la réponse
        $response->assertStatus(200);
        $response->assertJson(['message' => 'La commande a été réussi.']);
    }
    
}

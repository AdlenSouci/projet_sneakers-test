<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Article;
use App\Models\CommandeDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeEnteteFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('fr_FR');
        $user = User::inRandomOrder()->first();
        if (!$user) {
            throw new \Exception('Aucun utilisateur trouvé. Veuillez d\'abord créer des utilisateurs.');
        }
        return [
            'date' => $faker->dateTimeBetween('-1 year', 'now'),
            'id_user' => $user->id,
            'name' => $user->name,
            'telephone' => $user->telephone,
            'ville' => $user->ville,
            'code_postal' => $user->code_postal,
            'adresse_livraison' => $user->adresse_livraison,
            'id_num_commande' => $faker->unique()->numberBetween(100000, 999999),

            // Valeurs temporaires — mises à jour après les lignes
            'total_ht' => 0,
            'total_ttc' => 0,
            'total_tva' => 0,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($commande) {
            $faker = \Faker\Factory::create('fr_FR');

            $nbLignes = rand(2, 5);

            $totalHT = 0;
            $totalTVA = 0;
            $totalTTC = 0;

            for ($i = 0; $i < $nbLignes; $i++) {
                // Crée une ligne via le factory (utilise les vrais prix des articles)
                $ligne = \App\Models\CommandeDetail::factory()->create([
                    'id_commande' => $commande->id,
                ]);

                $totalHT += $ligne->prix_ht * $ligne->quantite;
                $totalTVA += $ligne->montant_tva * $ligne->quantite;
                $totalTTC += $ligne->prix_ttc * $ligne->quantite;
            }

            $commande->update([
                'total_ht' => round($totalHT, 2),
                'total_tva' => round($totalTVA, 2),
                'total_ttc' => round($totalTTC, 2),
            ]);
        });
    }
}

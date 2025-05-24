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

        return [
            'date' => $faker->dateTimeBetween('-1 year', 'now'),
            'id_user' => User::inRandomOrder()->value('id'),// Associe un utilisateur généré
            'name' => $faker->name(),
            'telephone' => $faker->phoneNumber(),
            'ville' => $faker->city(),
            'code_postal' => $faker->postcode(),
            'adresse_livraison' => $faker->address(),
            'id_num_commande' => $faker->unique()->numberBetween(100000, 999999),

            // Valeurs temporaires — mises à jour après les lignes
            'total_ht' => 0,
            'total_ttc' => 0,
            'total_tva' => 0,
            'total_remise' => 0,
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
            $totalRemise = 0;

            for ($i = 0; $i < $nbLignes; $i++) {
                $quantite = $faker->numberBetween(1, 5);
                $prix_ht = $faker->randomFloat(2, 10, 100);
                $remise = $faker->optional(0.3)->randomFloat(2, 1, 10); // 30% chance
                $prix_apres_remise = $prix_ht - ($remise ?? 0);
                $montant_tva = round($prix_apres_remise * 0.20, 2);
                $prix_ttc = round($prix_apres_remise + $montant_tva, 2);

                $detail = CommandeDetail::create([
                    'id_commande' => $commande->id,
                    'id_article' => Article::inRandomOrder()->value('id'), // Associe un article généré
                    'taille' => $faker->numberBetween(36, 45),
                    'quantite' => $quantite,
                    'prix_ht' => $prix_ht,
                    'prix_ttc' => $prix_ttc,
                    'montant_tva' => $montant_tva,
                    'remise' => $remise,
                ]);

                $totalHT += $prix_ht * $quantite;
                $totalTVA += $montant_tva * $quantite;
                $totalTTC += $prix_ttc * $quantite;
                $totalRemise += ($remise ?? 0) * $quantite;
            }

            $commande->update([
                'total_ht' => round($totalHT, 2),
                'total_tva' => round($totalTVA, 2),
                'total_ttc' => round($totalTTC, 2),
                'total_remise' => round($totalRemise, 2),
            ]);
        });
    }
}

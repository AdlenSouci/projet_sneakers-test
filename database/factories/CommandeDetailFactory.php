<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeDetailFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('fr_FR');

        $quantite = $faker->numberBetween(1, 5);
        $prix_ht = $faker->randomFloat(2, 10, 100);
        $montant_tva = round($prix_ht * 0.20, 2); // 20% TVA
        $prix_ttc = round($prix_ht + $montant_tva, 2);

        return [
            'id_article' => \App\Models\Article::inRandomOrder()->value('id'), // lien vers un article existant
            'taille' => $faker->numberBetween(36, 45),
            'quantite' => $quantite,
            'prix_ht' => round($prix_ht, 2),
            'prix_ttc' => $prix_ttc,
            'montant_tva' => $montant_tva,
            // 'remise' supprimé
        ];
    }
}

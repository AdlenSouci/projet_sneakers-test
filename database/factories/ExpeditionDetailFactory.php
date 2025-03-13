<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\expedition_detail>
 */
class ExpeditionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_num_commande' => $this->faker->unique()->randomNumber(5), // Utilise la méthode unique() pour garantir l'unicité du numéro de commande
            'id_num_bon_livraison' => $this->faker->unique()->sentence(5), // Utilise la méthode unique() pour garantir l'unicité du numéro de bon de livraison
            'id_num_ligne_bon_livraison' => $this->faker->randomNumber(5),
            'id_article' => $this->faker->randomNumber(5),
            'quantite_livraison' => $this->faker->randomNumber(3),
            'prix_unitaire_brut' => $this->faker->randomFloat(2, 10, 100),
            'prix_unitaire_net' => $this->faker->randomFloat(2, 5, 90),
            'montant_ht' => $this->faker->randomFloat(2, 50, 500),
            'remise' => $this->faker->randomFloat(2, 0, 10),


        ];
    }
}

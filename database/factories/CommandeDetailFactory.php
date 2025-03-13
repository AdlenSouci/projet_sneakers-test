<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\commande_detail>
 */
class CommandeDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_num_commande' => $this->faker->unique()->randomNumber(5),
            'id_article' => $this->faker->sentence(5),
            'id_quantite_commmande' => $this->faker->randomNumber(3),
            'prix_unitaire_brut' => $this->faker->randomFloat(2, 10, 100),
            'prix_unitaire_net' => $this->faker->randomFloat(2, 5, 90),
            'montant_ht' => $this->faker->randomFloat(2, 50, 500),
            'remise' => $this->faker->randomFloat(2, 0, 10),

        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\expedition_entete>
 */
class ExpeditionEnteteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_num_bon_livraison' => $this->faker->unique()->randomNumber(5), // Utilise la méthode unique() pour garantir l'unicité du numéro de bon de livraison
            'id_clients' => $this->faker->numberBetween(1, 100), // Utilise la méthode numberBetween() pour générer un nombre entre 1 et 100 (ajustez la plage selon vos besoins)
            'date' => $this->faker->date(), // Utilise la méthode date() pour générer une date aléatoire


        ];
    }
}

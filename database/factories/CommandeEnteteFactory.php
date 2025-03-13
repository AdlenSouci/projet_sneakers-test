<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\commande_entete>
 */
class CommandeEnteteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(), // Utilise la méthode date() pour générer une date aléatoire
            'id_clients' => $this->faker->numberBetween(1, 100), // Utilise la méthode numberBetween() pour générer un nombre entre 1 et 100 (ajustez la plage selon vos besoins)
            'id_num_commande' => $this->faker->unique()->randomNumber(5), // Utilise la méthode unique() pour garantir l'unicité du numéro de commande


        ];
    }
}

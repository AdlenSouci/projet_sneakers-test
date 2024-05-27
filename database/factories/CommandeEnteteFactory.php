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
            'id_clients' => $this->faker->numberBetween(1, 100), 
            'id_num_commande' => $this->faker->unique()->randomNumber(5),


        ];
    }
}

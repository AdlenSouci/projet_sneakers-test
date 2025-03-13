<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'date_de_naissance' => $this->faker->date(),
            'adresse' => $this->faker->localCoordinates(),
            'cp' => $this->faker->postcode(),
            'ville' => $this->faker->city(),
            'pays' => $this->faker->country(),
            'adresse2' => $this->faker->localCoordinates(),
            'cp2' => $this->faker->postcode(),
            'ville2' => $this->faker->city(),
            'pays2' => $this->faker->country(),
            'sexe' => $this->faker->randomElement(['homme', 'femme', 'autre']),
            'telephone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'mot_de_passe' => $this->faker->password(),
        
            
        ];
    }
}

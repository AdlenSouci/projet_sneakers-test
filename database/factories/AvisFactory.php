<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\User;

class AvisFactory extends Factory
{

   public function definition(): array
    {
        $faker = \Faker\Factory::create('fr_FR');

        $avis = [
            ["phrase" => "Très bon article !", "notes" => [5]],
            ["phrase" => "Je recommande cet article", "notes" => [4, 5]],
            ["phrase" => "C'est un excellent article", "notes" => [5]],
            ["phrase" => "Je suis déçu", "notes" => [1, 2]],
            ["phrase" => "C'est un bon début", "notes" => [3, 4]],
        ];

        $avisAleatoire = $faker->randomElement($avis);
        $noteAleatoire = $faker->randomElement($avisAleatoire["notes"]);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'article_id' => Article::inRandomOrder()->first()->id,
            'contenu' => $avisAleatoire["phrase"],
            'note' => $noteAleatoire,
        ];
    }
}
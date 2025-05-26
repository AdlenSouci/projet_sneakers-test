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

        $phrases = [
            "Très bon article !",
            "Je recommande cet article",
            "C'est un excellent article",
            "Je suis déçu",
            "C'est un bon début",
        ];

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'article_id' => Article::inRandomOrder()->first()->id,
            'contenu' => $faker->randomElement($phrases),
            'note' => rand(1, 5),
        ];
    }
}
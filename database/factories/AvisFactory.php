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

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'article_id' => Article::inRandomOrder()->first()->id,
            'contenu' => $faker->text(),
            'note' => rand(1, 5),      
        ];
    }
}

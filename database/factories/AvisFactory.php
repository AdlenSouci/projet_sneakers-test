<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\User;

class AvisFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'article_id' => Article::inRandomOrder()->first()->id,
            'contenu' => $this->faker->text(),
            'note' => rand(0, 5),      
        ];
    }
}

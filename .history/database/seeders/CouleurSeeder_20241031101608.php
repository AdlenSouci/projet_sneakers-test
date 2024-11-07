<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouleurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $couleurs = [
            ['nom_couleur' => 'noir', 'article_id' => 1],
            ['nom_couleur' => 'blanc', 'article_id' => 1],
            ['nom_couleur' => 'gris', 'article_id' => 2],
            ['nom_couleur' => 'rouge', 'article_id' => 3],
            ['nom_couleur' => 'vert', 'article_id' => 4],
            ['nom_couleur' => 'bleu', 'article_id' => 5],
            ['nom_couleur' => 'violet', 'article_id' => 6],
            ['nom_couleur' => 'jaune', 'article_id' => 7],
            ['nom_couleur' => 'marron', 'article_id' => 8],
            ['nom_couleur' => 'rose', 'article_id' => 9],
            ['nom_couleur' => 'Noir/Blanc', 'article_id' => 10],
            ['nom_couleur' => 'University Blue', 'article_id' => 11],
            ['nom_couleur' => 'Core Black/White', 'article_id' => 12],
            ['nom_couleur' => 'Blanc/Noir', 'article_id' => 13],
        ];

        foreach ($couleurs as $couleur) {
            DB::table('couleurs')->insert($couleur);
        }
    }
}

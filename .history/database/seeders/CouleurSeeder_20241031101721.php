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
            'noir',
            'blanc',
            'gris',
            'rouge',
            'vert',
            'bleu',
            'violet',
            'jaune',
            'marron',
            'rose',
            'Noir/Blanc',          // Nouvelle couleur
            'University Blue',      // Nouvelle couleur
            'Core Black/White',     // Nouvelle couleur
            'Blanc/Noir',           // Nouvelle couleur
        ];

        foreach ($couleurs as $couleur) {
            DB::table('couleurs')->insert([
                'nom_couleur' => $couleur
            ]);
        }
    }
}

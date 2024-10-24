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
        DB::table('couleurs')->insert([
            'nom_couleur'  => 'noir'
        ]);
        DB::table('couleurs')->insert([
            'nom_couleur'  => 'blanc'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'gris'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'rouge'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'vert'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'bleu'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'violet'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'jaune'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'marron'
        ]);

        DB::table('couleurs')->insert([
            'nom_couleur'  => 'rose'
        ]);

    }
}

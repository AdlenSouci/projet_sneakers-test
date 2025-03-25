<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Descriptor\TextDescriptor;

class AnnoncesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('annonces')->insert([
            "h1" => "<strong>My sneakers</strong> Shop",
            "h3" => "Le site ou vous pouvez acheter la sublime <strong> Air Max x Patta </strong>",
            "texte" => "Voici <a rel=\"sponsored\" class=\"text-success\" href=\"https://solesavy.com/history-of-patta-and-nike-collaborations/\" target=\"_blank\">l'histoire</a> de l'Air Max x Patta",
            "imageURL" => "patta.webp",
            "statut" => "publié",
        ]);
        DB::table('annonces')->insert([
            "h1" => "Assics revient avec du très lourd",
            "h3" => "La qualité au top de gamme",
            "texte" => "",
            "imageURL" => "lyte3.webp",
            "statut" => "publié",
        ]);
        DB::table('annonces')->insert([
            "h1" => "Nike x Off-White",
            "h3" => "Une paire rare presque introuvable sauf en occasion mais ici tout est possible",
            "texte" => "Une collaboration exeptionnelle entre Nike et off-white.",
            "imageURL" => "off.jpeg",
            "statut" => "publié",
        ]);
    }
}

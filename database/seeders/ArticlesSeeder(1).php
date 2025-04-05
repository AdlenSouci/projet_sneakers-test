<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            'id_marque' => 1,
            'id_famille' => 1,
            'modele' => 'Campus 00s',
            'id_couleur' => 3,
            'description' => 'Les sneakers Adidas Campus 00s présentent une silhouette basse dinspiration old school. Lempeigne revêt une superposition dempiècements en cuir suédé gris, surmontée par des renforts blancs sur le quartier. Retrouvez linimitable logo trèfle marqué sur le talon et la languette.',
            'prix_public' => 120.00,
            'prix_achat' => 100.00,
            'img' => 'campus.webp',
        ]);

        DB::table('articles')->insert([
            'id_marque' => 2,
            'id_famille' => 1,
            'modele' => "Dunk Low SB",
            'id_couleur' => 3,
            'description' => 'Conçue pour les parquets, mais adoptée par le streetwear, licône du basket fait son grand retour avec des détails classiques et un style rétro inspiré du terrain. Le col bas rembourré et la semelle intermédiaire en mousse te permettent de déployer ton jeu partout dans le plus grand confort.',
            'prix_public' => 150.00,
            'prix_achat' => 125.00,
            'img' => 'sb.webp',
        ]);

        DB::table('articles')->insert([
            'id_marque' => 2,
            'id_famille' => 2,
            'modele' => 'Dunk Low Valentine Day',
            'id_couleur' => 10,
            'description' => 'La Nike Dunk Low Retro PRM Valentines Day (2023) affiche une base en cuir bordeaux qui laisse apparaître des superpositions de cuir blanc cassé. Sur les côtés, un swoosh rose vient apporter une touche colorée à lensemble. Le tout se laisse sublimer par une semelle crème à loutsole assortie qui finalise le design.',
            'prix_public' => 160.00,
            'prix_achat' => 133.34,
            'img' => 'valentine.webp',
        ]);

        DB::table('articles')->insert([
            'id_marque' => 2,
            'id_famille' => 1,
            'modele' => 'Dunk Low Panda',
            'id_couleur' => 11,
            'description' => 'La Nike Dunk Low Black White arbore une tige en cuir blanc, rehaussée par des empiècements en cuir noir pour un contraste tout en sobriété. On retrouve un branding NIKE sur la languette et loutsole. Le jeu de couleur Black & White, aussi appelé "Panda", se poursuit également sur les semelles.',
            'prix_public' => 140.00,
            'prix_achat' => 116.67,
            'img' => 'panda.webp',
        ]);

        DB::table('articles')->insert([
            'id_marque' => 2,
            'id_famille' => 1,
            'modele' => 'Air Max 1 Patta',
            'id_couleur' => 2,
            'description' => 'La Nike Air Max 1 Patta White Grey présente une base en mesh gris complétée par des superpositions de cuir blanc aux détails craquelés. On retrouve notamment le fameux mudguard ondulé en forme de vagues, signature de la collection. Un mini-swoosh ainsi quune semelle crème viennent finaliser le design épuré.',
            'prix_public' => 180.00,
            'prix_achat' => 150.00,
            'img' => 'patta.webp',
        ]);

        DB::table('articles')->insert([
            'id_marque' => 4,
            'id_famille' => 1,
            'modele' => '574 Black White',
            'id_couleur' => 11,
            'description' => 'Cette New Balance 574 Black White (2022) présente une base en mesh noir, accompagnée de superpositions en daim ton sur ton. On distingue également un empiècement en daim beige sur chaque côté de la chaussure tandis que le heel tab se pare de cuir blanc pour saccorder à la midsole. Une touche de TPU gris équipe le talon alors que le "N" latéral se met en évidence grâce à un contour en cuir blanc. ',
            'prix_public' => 130.00,
            'prix_achat' => 108.33,
            'img' => '574.webp',
        ]);

        DB::table('articles')->insert([
            'id_marque' => 2,
            'id_famille' => 1,
            'modele' => 'Off-White X Air Jordan 1',
            'id_couleur' => 4,
            'description' => 'La collaboration emblématique entre Off-White et Nike, l\'Air Jordan 1 arbore un design unique avec des détails de conception distinctifs de Virgil Abloh.',
            'prix_public' => 500.00,
            'prix_achat' => 416.67,
            'img' => 'off.webp',
        ]);

        DB::table('articles')->insert([
            'modele' => '990v5',
            'id_marque' => 4,
            'id_famille' => 3,
            'id_couleur' => 3,
            'description' => 'La New Balance 990v5 est reconnue pour son confort exceptionnel et son design intemporel, en particulier dans des coloris classiques comme le gris.',
            'prix_public' => 150.00,
            'prix_achat' => 125.00,
            'img' => '990.webp',
        ]);

        DB::table('articles')->insert([
            'modele' => 'Gel-Lyte III "CLOT"',
            'id_marque' => 5,
            'id_famille' => 3,
            'id_couleur' => 3,
            'description' => 'Une collaboration spéciale entre Asics et CLOT, la Gel-Lyte III présente des détails de conception uniques et des matériaux de haute qualité.',
            'prix_public' => 232.00,
            'prix_achat' => 193.33,
            'img' => 'lyte3.webp',
        ]);

        DB::table('articles')->insert([
            'modele' => 'salomon xt 6"',
            'id_marque' => 6,
            'id_famille' => 3,
            'id_couleur' => 2,
            'description' => 'La Salomon XT 6" est une chaussure de sport de haute qualité offrant une sensation de confort et de performance exceptionnelles.',
            'prix_public' => 300.00,
            'prix_achat' => 250.00,
            'img' => 'xt6.webp',
        ]);
    }
}

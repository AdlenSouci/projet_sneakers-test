<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaillesArticlesSeeder extends Seeder
{

    public function run(): void
    {
        for ($j = 1; $j < 10; $j++) {
            for ($i = 38; $i < 43; $i++) {
                DB::table('tailles_articles')->insert([
                    'article_id' => $j,
                    'taille' => $i,
                    'stock' => random_int(0, 10)
                ]);
            }
        }
    }
}

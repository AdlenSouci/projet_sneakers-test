<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\Client::factory(100)->create();

       
      
        $this->call([
            FamilleSeeder::class,
            MarquesSeeder::class,
            TvasSeeder::class,
            CouleurSeeder::class,
            ArticlesSeeder::class,
            AdminSeeder::class,
            TaillesArticlesSeeder::class
            
        ]);
    

      
    }
}

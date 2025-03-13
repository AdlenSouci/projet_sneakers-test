<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\Client::factory(100)->create();

       
        $this->call([UsersSeeder::class]);        
        $this->call([MarquesSeeder::class]);
        $this->call([FamillesSeeder::class]);
        $this->call([PaysSeeder::class]);
        $this->call([ArticlesSeeder::class]);
        $this->call([TvasSeeder::class]);
        $this->call([TaillesArticlesSeeder::class]);
    

      
    }
}

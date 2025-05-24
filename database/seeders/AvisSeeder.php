<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Avis;

class AvisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Avis::factory(50)->create();
    }
}

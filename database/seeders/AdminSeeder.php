<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {


        User::create([
            'name' => 'admin', //choisir le name
            'email' => 'admin@example.com',//choisir email
            'password' => Hash::make('44-SS_qq'), // choisir le mot de passe 
            'is_admin' => true, //et is admin true pour avoir un user administrateur 
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Couleur;

class CouleursController extends Controller
{
    public function index()
    {
        $couleurs = Couleur::all();
        return response()->json($couleurs);
    }

    
}

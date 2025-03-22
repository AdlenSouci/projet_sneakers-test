<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marque;

class MarquesController extends Controller
{
    // Récupérer toutes les marques
    public function index()
    {
        return response()->json(Marque::all());
    }

   
   
}

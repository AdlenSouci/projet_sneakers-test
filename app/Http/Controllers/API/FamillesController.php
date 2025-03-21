<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Famille;

class FamillesController extends Controller
{
    public function index()
    {
        $familles = Famille::all();
        return response()->json($familles);
    }

    
}

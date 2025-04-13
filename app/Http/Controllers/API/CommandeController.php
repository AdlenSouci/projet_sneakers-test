<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommandeDetail;
use App\Models\CommandeEntete;

class CommandeController extends Controller
{
    public function index()
    {
        // Récupérer les entêtes de commandes (associées aux détails)
        $commandes = CommandeEntete::with('details')->get();
        return response()->json($commandes);
    }
}

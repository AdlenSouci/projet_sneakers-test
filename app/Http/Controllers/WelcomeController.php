<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        $annonces = Annonce::all();
        return view('index', compact('annonces'));
    }
}

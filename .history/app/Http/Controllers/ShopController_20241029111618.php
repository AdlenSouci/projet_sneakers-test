<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        // Récupérer les articles avec leurs avis
        $articlesData = Article::with('avis')->get();

        return view('shop', compact('articlesData'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articlesData'));
    }

    public function filter(Request $request)
    {
        $familles = $request->input('familles');
        $marques = $request->input('marques');
        $couleurs = $request->input('couleurs');
        
}

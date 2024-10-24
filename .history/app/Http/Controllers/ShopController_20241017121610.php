<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ShopController extends Controller
{
    public function index(): View
    {
        $articlesData = Article::all();
        $articlesData = Article::with('avis')->get();
        return view('shop', compact('articlesData'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->get();
        return view('shop', compact('articlesData'));
    }
}